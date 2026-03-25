<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/auth.php';

// Validar que el usuario sea Admin (admin, subadmin, superadmin)
requireAdmin();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->userId) || empty($data->userId)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "El parámetro 'userId' es requerido."]);
    exit;
}

$userId = intval($data->userId);

$database = new Database();
$db = $database->getConnection();

try {
    // Construcción dinámica del query asegurando Nomenclatura STRICT camelCase
    $updates = [];
    $params = [];
    
    // riskProfile
    if (isset($data->riskProfile)) {
        $updates[] = "riskProfile = :riskProfile";
        $params[':riskProfile'] = htmlspecialchars(strip_tags($data->riskProfile), ENT_QUOTES, 'UTF-8');
    }
    
    // annualReturnRate
    if (isset($data->annualReturnRate)) {
        $updates[] = "annualReturnRate = :annualReturnRate";
        $params[':annualReturnRate'] = floatval($data->annualReturnRate);
    }
    
    // investmentPeriod
    if (isset($data->investmentPeriod)) {
        $updates[] = "investmentPeriod = :investmentPeriod";
        $params[':investmentPeriod'] = htmlspecialchars(strip_tags($data->investmentPeriod), ENT_QUOTES, 'UTF-8');
    }
    
    // nextInvestmentDate
    if (isset($data->nextInvestmentDate)) {
        $updates[] = "nextInvestmentDate = :nextInvestmentDate";
        $params[':nextInvestmentDate'] = !empty($data->nextInvestmentDate) ? htmlspecialchars(strip_tags($data->nextInvestmentDate), ENT_QUOTES, 'UTF-8') : null;
    }
    
    if (empty($updates)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "No se enviaron datos financieros para actualizar."]);
        exit;
    }

    $query = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = :userId";
    $params[':userId'] = $userId;

    $stmt = $db->prepare($query);
    
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val);
    }
    
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "message" => "Perfil financiero actualizado correctamente.",
                "updatedFields" => array_keys($params)
            ]);
        } else {
            // RowCount es 0 si el ID no existe O si los datos enviados son exactamente los mismos que ya estaban.
            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "message" => "Ningún dato modificado (es posible que los valores sean idénticos a los actuales o el usuario no exista)."
            ]);
        }
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Error al actualizar la base de datos."]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error de base de datos: " . $e->getMessage()
    ]);
}
?>