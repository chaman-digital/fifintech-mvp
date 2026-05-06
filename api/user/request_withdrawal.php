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
$userId = intval($user['id']);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->amount) || !isset($data->bankName) || !isset($data->clabe) || !isset($data->accountHolder)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios para el retiro."]);
    exit;
}

$amount = floatval($data->amount);
if ($amount <= 0) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "El monto debe ser mayor a 0."]);
    exit;
}

$database = new Database();
$db = $database->getConnection();

try {
    // Calcular balance total
    $queryBalance = "
        SELECT 
            COALESCE(SUM(CASE WHEN type = 'deposit' AND status = 'completed' THEN amount ELSE 0 END), 0) AS netDeposits,
            COALESCE(SUM(CASE WHEN type = 'withdrawal' AND status IN ('completed', 'pending') THEN amount ELSE 0 END), 0) AS netWithdrawals
        FROM transactions 
        WHERE userId = :userId
    ";
    
    $stmtBalance = $db->prepare($queryBalance);
    $stmtBalance->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmtBalance->execute();
    
    $rowBalance = $stmtBalance->fetch(PDO::FETCH_ASSOC);
    // Para el cálculo del límite de retiro, consideramos también los retiros 'pending' en netWithdrawals
    // para no permitir solicitar múltiples retiros que excedan el límite
    $totalBalance = floatval($rowBalance['netDeposits']) - floatval($rowBalance['netWithdrawals']);
    
    // Validar el 75%
    $maxAvailable = $totalBalance * 0.75;
    
    if ($amount > $maxAvailable) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "No puedes retirar más del 75% de tu balance disponible. Cantidad máxima: $" . number_format($maxAvailable, 2)]);
        exit;
    }

    $details = json_encode([
        "bankName" => $data->bankName,
        "clabe" => $data->clabe,
        "accountHolder" => $data->accountHolder
    ]);

    $query = "INSERT INTO transactions (userId, type, amount, status, details) VALUES (:userId, 'withdrawal', :amount, 'pending', :details)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':details', $details);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(["status" => "success", "message" => "Solicitud de retiro registrada correctamente."]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Error al registrar la solicitud."]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Error del servidor: " . $e->getMessage()]);
}
?>
