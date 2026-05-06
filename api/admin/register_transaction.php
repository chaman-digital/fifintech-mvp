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

try {
    // Check if the user exists and fetch their profile data
    $userQuery = "SELECT data FROM user_profiles WHERE userId = :userId LIMIT 1";
    $userStmt = $db->prepare($userQuery);
    $userStmt->bindParam(":userId", $userId, PDO::PARAM_INT);
    $userStmt->execute();

    if ($userStmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode([
            "status" => "error",
            "message" => "User profile not found."
        ]);
        exit;
    }
    
    $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);
    $profileData = json_decode($userRow['data'], true);
    if (!is_array($profileData)) {
        $profileData = [];
    }

    // Start transaction to ensure atomicity
    $db->beginTransaction();

    // 1. Insert the transaction (no description, no authNumber, no customDate in DB)
    $query = "INSERT INTO transactions (userId, type, amount, status) VALUES (:userId, :type, :amount, 'completed')";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":type", $type, PDO::PARAM_STR);
    $stmt->bindParam(":amount", $amount, PDO::PARAM_STR); 
    
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

        // If this is the FIRST deposit ever
        if (intval($countRow['depositCount']) === 1) {
            
            // Determine base date to calculate from
            $baseDate = new DateTime();
            
            // Calculate interval based on user preference
            $investmentPeriod = isset($profileData['investmentPeriod']) ? $profileData['investmentPeriod'] : 'Mensual';
            if ($investmentPeriod === 'Quincenal') {
                $baseDate->modify('+15 days');
            } else {
                // Default to 'Mensual'
                $baseDate->modify('+30 days');
            }
            
            $nextInvestmentDate = $baseDate->format('Y-m-d');
            
            // Update the user profile JSON
            $profileData['nextInvestmentDate'] = $nextInvestmentDate;
            $newJson = json_encode($profileData);
            
            $updateUserQuery = "UPDATE user_profiles SET data = :data WHERE userId = :userId";
            $updateUserStmt = $db->prepare($updateUserQuery);
            $updateUserStmt->bindParam(":data", $newJson, PDO::PARAM_STR);
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