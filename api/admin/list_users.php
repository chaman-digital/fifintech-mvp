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
    // 1. list_users: JOIN entre users y transactions para listar a todos los inversionistas
    $query = "
        SELECT 
            u.id, 
            u.firstName, 
            u.lastName, 
            u.email,
            COALESCE(
                SUM(CASE WHEN t.type = 'deposit' AND t.status = 'completed' THEN t.amount ELSE 0 END) - 
                SUM(CASE WHEN t.type = 'withdrawal' AND t.status = 'completed' THEN t.amount ELSE 0 END), 0
            ) AS totalBalance
        FROM users u
        LEFT JOIN transactions t ON u.id = t.userId
        WHERE u.role = 'user'
        GROUP BY u.id
        ORDER BY u.firstName ASC
    ";

    $stmt = $db->prepare($query);
    $stmt->execute();

    $users = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[] = [
            "id" => intval($row['id']),
            "firstName" => htmlspecialchars($row['firstName'], ENT_QUOTES, 'UTF-8'),
            "lastName" => htmlspecialchars($row['lastName'], ENT_QUOTES, 'UTF-8'),
            "email" => htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'),
            "totalBalance" => floatval($row['totalBalance']),
            "annualReturnRate" => 12.5, // Fase 3 Requisito: Inyectado estáticamente
            "riskProfile" => "Moderate" // Fase 3 Requisito: Inyectado estáticamente
        ];
    }

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "count" => count($users),
        "users" => $users
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error al obtener lista de usuarios: " . $e->getMessage()
    ]);
}
?>