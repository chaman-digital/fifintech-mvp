<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/auth.php';

// Validar que el usuario sea Admin (incluye superadmin y subadmin)
requireAdmin();

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

// Validation
if (empty($data->userId) || empty($data->type) || empty($data->amount)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields: userId, type, amount"
    ]);
    exit;
}

$allowedTypes = ['deposit', 'withdrawal'];
$type = strtolower(trim($data->type));

if (!in_array($type, $allowedTypes)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid transaction type. Allowed types are: " . implode(', ', $allowedTypes)
    ]);
    exit;
}

$userId = intval($data->userId);
$amount = floatval($data->amount);

if ($amount <= 0) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Amount must be greater than zero."
    ]);
    exit;
}

$description = isset($data->description) ? htmlspecialchars(strip_tags($data->description), ENT_QUOTES, 'UTF-8') : "Depósito registrado por administración";
$authNumber = isset($data->authNumber) && !empty($data->authNumber) ? htmlspecialchars(strip_tags($data->authNumber), ENT_QUOTES, 'UTF-8') : null;
$customDate = isset($data->customDate) && !empty($data->customDate) ? htmlspecialchars(strip_tags($data->customDate), ENT_QUOTES, 'UTF-8') : null;

try {
    // Check if the user exists and fetch their investment settings
    $userQuery = "SELECT id, investmentPeriod, nextInvestmentDate FROM users WHERE id = :userId LIMIT 1";
    $userStmt = $db->prepare($userQuery);
    $userStmt->bindParam(":userId", $userId, PDO::PARAM_INT);
    $userStmt->execute();

    if ($userStmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode([
            "status" => "error",
            "message" => "User not found."
        ]);
        exit;
    }
    
    $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);

    // Start transaction to ensure atomicity
    $db->beginTransaction();

    // 1. Insert the transaction
    $query = "INSERT INTO transactions (userId, type, amount, description, status, authNumber, customDate) VALUES (:userId, :type, :amount, :description, 'completed', :authNumber, :customDate)";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":type", $type, PDO::PARAM_STR);
    $stmt->bindParam(":amount", $amount, PDO::PARAM_STR); 
    $stmt->bindParam(":description", $description, PDO::PARAM_STR);
    $stmt->bindParam(":authNumber", $authNumber, PDO::PARAM_STR);
    $stmt->bindParam(":customDate", $customDate, PDO::PARAM_STR);
    
    if (!$stmt->execute()) {
        throw new Exception("Unable to register transaction in DB.");
    }
    
    $transactionId = $db->lastInsertId();

    // 2. Business Logic: Auto-calculate nextInvestmentDate IF it's the first deposit
    if ($type === 'deposit') {
        // Count how many completed deposits this user has
        $countQuery = "SELECT COUNT(id) as depositCount FROM transactions WHERE userId = :userId AND type = 'deposit' AND status = 'completed'";
        $countStmt = $db->prepare($countQuery);
        $countStmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $countStmt->execute();
        $countRow = $countStmt->fetch(PDO::FETCH_ASSOC);

        // If this is the FIRST deposit ever (depositCount will be 1 because we just inserted it in the same transaction)
        if (intval($countRow['depositCount']) === 1) {
            
            // Determine base date to calculate from
            $baseDateStr = $customDate ? $customDate : date('Y-m-d H:i:s');
            $baseDate = new DateTime($baseDateStr);
            
            // Calculate interval based on user preference
            $investmentPeriod = $userRow['investmentPeriod']; // 'Mensual' or 'Quincenal'
            if ($investmentPeriod === 'Quincenal') {
                $baseDate->modify('+15 days');
            } else {
                // Default to 'Mensual'
                $baseDate->modify('+30 days');
            }
            
            $nextInvestmentDate = $baseDate->format('Y-m-d');
            
            // Update the user
            $updateUserQuery = "UPDATE users SET nextInvestmentDate = :nextDate WHERE id = :userId";
            $updateUserStmt = $db->prepare($updateUserQuery);
            $updateUserStmt->bindParam(":nextDate", $nextInvestmentDate, PDO::PARAM_STR);
            $updateUserStmt->bindParam(":userId", $userId, PDO::PARAM_INT);
            
            if (!$updateUserStmt->execute()) {
                throw new Exception("Transaction registered, but failed to update nextInvestmentDate.");
            }
        }
    }

    $db->commit();

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "message" => "Transacción registrada",
        "transactionId" => $transactionId
    ]);

} catch (Exception $e) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>