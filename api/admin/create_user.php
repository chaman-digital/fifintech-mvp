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

require_once '../config/config.php';
require_once '../config/db.php';
require_once '../utils/auth.php';
require_once '../utils/qrcode.php';
require_once '../utils/smtp.php';

// Verify admin role
$adminUser = requireAdmin();

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

// Validation
if (empty($data->firstName) || empty($data->lastName) || empty($data->email) || empty($data->phone) || empty($data->password)) {
    http_response_code(400);
    echo json_encode(["message" => "Missing required fields."]);
    exit;
}

if (!preg_match('/^[0-9]{10}$/', $data->phone)) {
    http_response_code(400);
    echo json_encode(["message" => "Phone number must be exactly 10 digits."]);
    exit;
}

$email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
$firstName = htmlspecialchars(strip_tags($data->firstName), ENT_QUOTES, 'UTF-8');
$lastName = htmlspecialchars(strip_tags($data->lastName), ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars(strip_tags($data->phone), ENT_QUOTES, 'UTF-8');

// Check duplicates
$query = "SELECT id FROM users WHERE email = :email OR phone = :phone";
$stmt = $db->prepare($query);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":phone", $phone);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    http_response_code(409);
    echo json_encode(["message" => "Email or phone already exists."]);
    exit;
}

// Start transaction
$db->beginTransaction();

try {
    // Create user
    $query = "INSERT INTO users (firstName, lastName, email, phone, password, role) VALUES (:firstName, :lastName, :email, :phone, :password, 'user')";
    $stmt = $db->prepare($query);
    
    $password_hash = password_hash($data->password, PASSWORD_BCRYPT);
    
    $stmt->bindParam(":firstName", $firstName);
    $stmt->bindParam(":lastName", $lastName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":password", $password_hash);
    
    $stmt->execute();
    $userId = $db->lastInsertId();

    // Setup initial UserProfile data using BASE_URL
    $publicUrl = rtrim(BASE_URL, '/') . "/PublicProfile?userId=" . $userId;
    $qrCodeData = QRCodeGenerator::generateBase64($publicUrl);
    
    // Update user row directly with new fields
    $annualReturnRate = isset($data->annualReturnRate) ? floatval($data->annualReturnRate) : 0.0;
    $riskProfile = isset($data->riskProfile) ? htmlspecialchars(strip_tags($data->riskProfile), ENT_QUOTES, 'UTF-8') : 'Moderado';
    $investmentPeriod = isset($data->investmentPeriod) ? htmlspecialchars(strip_tags($data->investmentPeriod), ENT_QUOTES, 'UTF-8') : 'Mensual';
    $nextInvestmentDate = isset($data->nextInvestmentDate) && !empty($data->nextInvestmentDate) ? htmlspecialchars(strip_tags($data->nextInvestmentDate), ENT_QUOTES, 'UTF-8') : null;

    $queryUpdateUser = "UPDATE users SET annualReturnRate = :annualReturnRate, riskProfile = :riskProfile, investmentPeriod = :investmentPeriod, nextInvestmentDate = :nextInvestmentDate WHERE id = :userId";
    $stmtUpdateUser = $db->prepare($queryUpdateUser);
    $stmtUpdateUser->bindParam(":annualReturnRate", $annualReturnRate);
    $stmtUpdateUser->bindParam(":riskProfile", $riskProfile);
    $stmtUpdateUser->bindParam(":investmentPeriod", $investmentPeriod);
    $stmtUpdateUser->bindParam(":nextInvestmentDate", $nextInvestmentDate);
    $stmtUpdateUser->bindParam(":userId", $userId);
    $stmtUpdateUser->execute();
    
    // UserProfile still needed for the JSON dynamics and public URL
    $profileData = [];
    $profileDataJson = json_encode($profileData);
    
    $queryProfile = "INSERT INTO user_profiles (userId, publicUrl, data) VALUES (:userId, :publicUrl, :data)";
    $stmtProfile = $db->prepare($queryProfile);
    $stmtProfile->bindParam(":userId", $userId);
    $stmtProfile->bindParam(":publicUrl", $publicUrl);
    $stmtProfile->bindParam(":data", $profileDataJson);
    $stmtProfile->execute();

    $db->commit();
    
    // Attempt to send Welcome Email
    $mailer = new SimpleSMTP();
    $subject = "Bienvenido a Fintech MVP";
    $messageBody = "<h1>Hola {$firstName},</h1><p>Tu cuenta ha sido creada. Puedes acceder a tu perfil publico y descargar tu QR desde aquí:</p><p><a href='{$publicUrl}'>{$publicUrl}</a></p><p>Tambien hemos adjuntado tu QR virtual (Base64) en esta estructura: <br/><br/><img src='{$qrCodeData}' alt='Tu QR' /></p>";
    
    // We do not fail the request if the email fails, we just log it or ignore
    $mailer->send($email, $subject, $messageBody);

    http_response_code(201);
    echo json_encode([
        "message" => "User created successfully.",
        "user" => [
            "id" => $userId,
            "firstName" => $firstName,
            "lastName" => $lastName,
            "email" => $email,
            "phone" => $phone,
            "publicUrl" => $publicUrl,
            "qrCodeBase64" => $qrCodeData
        ]
    ]);
} catch (Exception $e) {
    $db->rollBack();
    http_response_code(500);
    echo json_encode(["message" => "Unable to create user.", "error" => $e->getMessage()]);
}
?>