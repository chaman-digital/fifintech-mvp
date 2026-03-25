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
require_once __DIR__ . '/../config/config.php'; // Para BASE_URL

// Validar que el usuario esté autenticado
$user = authenticate();
$userId = intval($user['id']);

$database = new Database();
$db = $database->getConnection();

// Directorio base para subidas
$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Variables a actualizar
$updates = [];
$params = [];

// 1. Manejo del teléfono (si se envió en la petición multipart)
if (isset($_POST['phone']) && !empty($_POST['phone'])) {
    $phone = htmlspecialchars(strip_tags($_POST['phone']), ENT_QUOTES, 'UTF-8');
    // Quitamos la validación estricta para el MVP, aceptamos el formato que el usuario escriba.
    $updates[] = "phone = :phone";
    $params[':phone'] = $phone;
}

// Función auxiliar para subir archivos de manera segura
function uploadFile($fileInputName, $uploadDir, $userId, $typePrefix) {
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$fileInputName]['tmp_name'];
        $fileName = $_FILES[$fileInputName]['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Extensiones permitidas (básicas para imágenes y pdfs)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            return ["error" => "Extensión no permitida para $fileInputName."];
        }

        // Generar nombre único: {prefijo}_{userId}_{timestamp}.{ext}
        $newFileName = $typePrefix . '_' . $userId . '_' . time() . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Retornamos la ruta relativa que se guardará en la base de datos
            return ["success" => "uploads/" . $newFileName];
        } else {
            return ["error" => "Error al mover el archivo subido $fileInputName."];
        }
    }
    return null; // No se subió archivo
}

// 2. Manejo de subida de Avatar
$avatarUpload = uploadFile('avatar', $uploadDir, $userId, 'avatar');
if ($avatarUpload && isset($avatarUpload['error'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $avatarUpload['error']]);
    exit;
} elseif ($avatarUpload && isset($avatarUpload['success'])) {
    $updates[] = "avatarUrl = :avatarUrl";
    $params[':avatarUrl'] = $avatarUpload['success'];
}

// 3. Manejo de subida de KYC Document
$kycUpload = uploadFile('kycDocument', $uploadDir, $userId, 'kyc');
if ($kycUpload && isset($kycUpload['error'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $kycUpload['error']]);
    exit;
} elseif ($kycUpload && isset($kycUpload['success'])) {
    $updates[] = "kycDocUrl = :kycDocUrl";
    $params[':kycDocUrl'] = $kycUpload['success'];
    
    // Si sube un documento KYC, el estado cambia automáticamente a under_review
    $updates[] = "kycStatus = 'under_review'";
}

// Si no hay nada que actualizar
if (empty($updates)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "No se enviaron datos válidos para actualizar."]);
    exit;
}

try {
    // Construir la consulta de UPDATE dinámicamente
    $query = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = :userId";
    $params[':userId'] = $userId;

    $stmt = $db->prepare($query);
    
    // Bind dinámico de los parámetros
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val);
    }
    
    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Perfil actualizado correctamente.",
            "dataUpdated" => array_keys($params) // Para fines de debug
        ]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar el perfil en la base de datos."]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>