<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/auth.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Cualquier usuario logueado puede ver la info bancaria
    authenticate();
    
    $query = "SELECT id, bankName, accountHolder, accountNumber, clabe, oxxoText, codiLink, updated_at FROM system_settings WHERE id = 1 LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
        http_response_code(200);
        echo json_encode(["status" => "success", "data" => $settings]);
    } else {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Settings not found."]);
    }
} 
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Solo SUPERADMIN puede modificar
    requireSuperAdmin();
    
    $data = json_decode(file_get_contents("php://input"));
    
    if (!$data) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "No data provided."]);
        exit;
    }
    
    $bankName = isset($data->bankName) ? htmlspecialchars(strip_tags($data->bankName), ENT_QUOTES, 'UTF-8') : null;
    $accountHolder = isset($data->accountHolder) ? htmlspecialchars(strip_tags($data->accountHolder), ENT_QUOTES, 'UTF-8') : null;
    $accountNumber = isset($data->accountNumber) ? htmlspecialchars(strip_tags($data->accountNumber), ENT_QUOTES, 'UTF-8') : null;
    $clabe = isset($data->clabe) ? htmlspecialchars(strip_tags($data->clabe), ENT_QUOTES, 'UTF-8') : null;
    $oxxoText = isset($data->oxxoText) ? htmlspecialchars(strip_tags($data->oxxoText), ENT_QUOTES, 'UTF-8') : null;
    $codiLink = isset($data->codiLink) ? htmlspecialchars(strip_tags($data->codiLink), ENT_QUOTES, 'UTF-8') : null;
    
    $query = "UPDATE system_settings SET bankName = :bankName, accountHolder = :accountHolder, accountNumber = :accountNumber, clabe = :clabe, oxxoText = :oxxoText, codiLink = :codiLink WHERE id = 1";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(":bankName", $bankName);
    $stmt->bindParam(":accountHolder", $accountHolder);
    $stmt->bindParam(":accountNumber", $accountNumber);
    $stmt->bindParam(":clabe", $clabe);
    $stmt->bindParam(":oxxoText", $oxxoText);
    $stmt->bindParam(":codiLink", $codiLink);
    
    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "System settings updated successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Failed to update system settings."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed."]);
}
?>