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

// Validar que el usuario sea Admin
requireAdmin();

$database = new Database();
$db = $database->getConnection();

try {
    // 1. totalAUM: Total dinámico (Depósitos completados - Retiros completados)
    $queryAUM = "SELECT 
                    COALESCE(SUM(CASE WHEN type = 'deposit' THEN amount ELSE 0 END) - 
                    SUM(CASE WHEN type = 'withdrawal' THEN amount ELSE 0 END), 0) AS netTotal
                 FROM transactions 
                 WHERE status = 'completed'";
    $stmtAUM = $db->prepare($queryAUM);
    $stmtAUM->execute();
    $rowAUM = $stmtAUM->fetch(PDO::FETCH_ASSOC);
    $totalAUM = floatval($rowAUM['netTotal']);

    // 2. totalTransactions: Conteo total de movimientos
    $queryTx = "SELECT COUNT(id) AS txCount FROM transactions";
    $stmtTx = $db->prepare($queryTx);
    $stmtTx->execute();
    $rowTx = $stmtTx->fetch(PDO::FETCH_ASSOC);
    $totalTransactions = intval($rowTx['txCount']);

    // 3. activeUsers: Conteo de usuarios registrados con rol 'user'
    $queryUsers = "SELECT COUNT(id) AS userCount FROM users WHERE role = 'user'";
    $stmtUsers = $db->prepare($queryUsers);
    $stmtUsers->execute();
    $rowUsers = $stmtUsers->fetch(PDO::FETCH_ASSOC);
    $activeUsers = intval($rowUsers['userCount']);

    // 4. totalYields: Por ahora es 0.00 (Fase 4)
    $totalYields = 0.00;

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "totalAUM" => $totalAUM,
        "totalTransactions" => $totalTransactions,
        "activeUsers" => $activeUsers,
        "totalYields" => $totalYields
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error al obtener estadísticas del dashboard: " . $e->getMessage()
    ]);
}
?>