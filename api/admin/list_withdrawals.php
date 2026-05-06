<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/auth.php';

$user = authenticate();
if (!in_array($user['role'], ['superadmin', 'admin', 'subadmin'])) {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acceso denegado."]);
    exit;
}

$database = new Database();
$db = $database->getConnection();

try {
    $query = "
        SELECT 
            t.id, t.userId, t.amount, t.status, t.date, t.details,
            u.firstName, u.lastName, u.email
        FROM transactions t
        JOIN users u ON t.userId = u.id
        WHERE t.type = 'withdrawal'
        ORDER BY t.date DESC
    ";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $withdrawals = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $details = $row['details'] ? json_decode($row['details'], true) : null;
        if (!$details) {
            $details = [
                "bankName" => "No especificado",
                "clabe" => "N/A",
                "accountHolder" => "N/A"
            ];
        }
        $row['details'] = $details;
        $withdrawals[] = $row;
    }

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "withdrawals" => $withdrawals
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Error del servidor: " . $e->getMessage()]);
}
?>
