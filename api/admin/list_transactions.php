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

// Validar que el usuario sea Admin (incluye superadmin y subadmin)
requireAdmin();

$database = new Database();
$db = $database->getConnection();

try {
    // JOIN con la tabla users para obtener el nombre completo
    // Si customDate existe se usará como fecha principal de la transacción, si no, se usará el 'date' por defecto.
    $query = "
        SELECT 
            t.id AS transactionId,
            t.type,
            t.amount,
            t.status,
            COALESCE(t.customDate, t.date) AS transactionDate,
            u.id AS userId,
            u.firstName,
            u.lastName
        FROM transactions t
        INNER JOIN users u ON t.userId = u.id
        ORDER BY transactionDate DESC
    ";

    $stmt = $db->prepare($query);
    $stmt->execute();

    $transactions = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $transactions[] = [
            "transactionId" => intval($row['transactionId']),
            "userId" => intval($row['userId']),
            "userName" => htmlspecialchars($row['firstName'] . ' ' . $row['lastName'], ENT_QUOTES, 'UTF-8'),
            "type" => $row['type'],
            "amount" => floatval($row['amount']),
            "status" => $row['status'],
            "date" => $row['transactionDate']
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
        "message" => "Error al obtener historial de transacciones: " . $e->getMessage()
    ]);
}
?>