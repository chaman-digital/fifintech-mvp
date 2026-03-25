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

if (!isset($_GET['userId']) || empty($_GET['userId'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "El parámetro 'userId' es requerido."]);
    exit;
}

$targetUserId = intval($_GET['userId']);

$database = new Database();
$db = $database->getConnection();

try {
    // Consultar toda la información relevante del usuario y su perfil
    $query = "
        SELECT 
            u.id, 
            u.firstName, 
            u.lastName, 
            u.email, 
            u.phone, 
            u.role, 
            u.annualReturnRate, 
            u.riskProfile, 
            u.investmentPeriod, 
            u.nextInvestmentDate, 
            u.avatarUrl, 
            u.kycDocUrl, 
            u.kycStatus, 
            u.created_at,
            p.publicUrl
        FROM users u
        LEFT JOIN user_profiles p ON u.id = p.userId
        WHERE u.id = :userId
        LIMIT 1
    ";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':userId', $targetUserId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Usuario no encontrado."]);
        exit;
    }

    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    // Formatear los datos para el JSON
    $userData = [
        "id" => intval($userRow['id']),
        "firstName" => htmlspecialchars($userRow['firstName'], ENT_QUOTES, 'UTF-8'),
        "lastName" => htmlspecialchars($userRow['lastName'], ENT_QUOTES, 'UTF-8'),
        "email" => htmlspecialchars($userRow['email'], ENT_QUOTES, 'UTF-8'),
        "phone" => htmlspecialchars($userRow['phone'], ENT_QUOTES, 'UTF-8'),
        "role" => $userRow['role'],
        "annualReturnRate" => floatval($userRow['annualReturnRate']),
        "riskProfile" => htmlspecialchars($userRow['riskProfile'], ENT_QUOTES, 'UTF-8'),
        "investmentPeriod" => $userRow['investmentPeriod'],
        "nextInvestmentDate" => $userRow['nextInvestmentDate'],
        "avatarUrl" => $userRow['avatarUrl'] ? htmlspecialchars($userRow['avatarUrl'], ENT_QUOTES, 'UTF-8') : null,
        "kycDocUrl" => $userRow['kycDocUrl'] ? htmlspecialchars($userRow['kycDocUrl'], ENT_QUOTES, 'UTF-8') : null,
        "kycStatus" => $userRow['kycStatus'],
        "publicUrl" => $userRow['publicUrl'] ? htmlspecialchars($userRow['publicUrl'], ENT_QUOTES, 'UTF-8') : null,
        "createdAt" => $userRow['created_at']
    ];

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "data" => $userData
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error al obtener la información del usuario: " . $e->getMessage()
    ]);
}
?>