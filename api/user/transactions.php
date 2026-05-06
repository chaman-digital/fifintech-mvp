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

// Validar JWT genérico (cualquier usuario logueado)
$user = authenticate();
$userId = intval($user['id']);

if (isset($_GET['userId']) && !empty($_GET['userId'])) {
    $dbRole = new Database();
    $conn = $dbRole->getConnection();
    $stmtRole = $conn->prepare("SELECT role FROM users WHERE id = :uid");
    $uidRole = $user['id'];
    $stmtRole->bindParam(':uid', $uidRole, PDO::PARAM_INT);
    $stmtRole->execute();
    $roleRow = $stmtRole->fetch(PDO::FETCH_ASSOC);
    
    if ($roleRow && in_array($roleRow['role'], ['superadmin', 'subadmin', 'admin'])) {
        $userId = intval($_GET['userId']); // Suplantar
    }
}

$database = new Database();
$db = $database->getConnection();

try {
    // Obtener historial completo de transacciones para el usuario activo
    $query = "SELECT id, type, amount, status, date as created_at FROM transactions WHERE userId = :userId ORDER BY date DESC";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $transactions = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $transactions[] = [
            "id" => intval($row['id']),
            "type" => $row['type'],
            "amount" => floatval($row['amount']),
            "status" => $row['status'],
            "date" => $row['created_at']
        ];
    }

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "count" => count($transactions),
        "transactions" => $transactions
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error al obtener transacciones: " . $e->getMessage()
    ]);
}
?>