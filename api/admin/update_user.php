<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/auth.php';

requireAdmin();

$data = json_decode(file_get_contents("php://input"));

if (empty($data->userId)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Falta el ID del usuario"]);
    exit;
}

$database = new Database();
$db = $database->getConnection();

try {
    $updates = [];
    
    if (isset($data->riskProfile)) $updates[] = "risk_profile = '" . htmlspecialchars(strip_tags($data->riskProfile)) . "'";
    if (isset($data->annualReturnRate)) $updates[] = "annual_return_rate = " . floatval($data->annualReturnRate);
    if (isset($data->nextInvestmentDate) && $data->nextInvestmentDate !== null && $data->nextInvestmentDate !== '') {
        $updates[] = "next_investment_date = '" . htmlspecialchars(strip_tags($data->nextInvestmentDate)) . "'";
    }
    if (isset($data->investmentPeriod) && $data->investmentPeriod !== null && $data->investmentPeriod !== '') {
        $updates[] = "investment_period = '" . htmlspecialchars(strip_tags($data->investmentPeriod)) . "'";
    }
    
    if (count($updates) === 0) {
       http_response_code(400);
       echo json_encode(["status" => "error", "message" => "No hay datos para actualizar"]);
       exit; 
    }
    
    $query = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = " . intval($data->userId);
    
    $stmt = $db->prepare($query);
    if($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Perfil de usuario actualizado correctamente."]);
    } else {
        throw new Exception("Error en la actualización de base de datos.");
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
