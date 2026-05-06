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

$user = authenticate();
if (!in_array($user['role'], ['superadmin', 'admin', 'subadmin'])) {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acceso denegado."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->transactionId) || !isset($data->action)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Faltan datos (transactionId o action)."]);
    exit;
}

$action = $data->action; // 'complete' or 'reject'
if (!in_array($action, ['complete', 'reject'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Acción inválida."]);
    exit;
}

$newStatus = ($action === 'complete') ? 'completed' : 'rejected';

$database = new Database();
$db = $database->getConnection();

try {
    $query = "UPDATE transactions SET status = :status, date = CURRENT_TIMESTAMP WHERE id = :id AND type = 'withdrawal' AND status = 'pending'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':status', $newStatus);
    $stmt->bindParam(':id', $data->transactionId, PDO::PARAM_INT);
    
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Solicitud procesada como: " . $newStatus]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "La solicitud no existe o ya fue procesada."]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Error del servidor: " . $e->getMessage()]);
}
?>
