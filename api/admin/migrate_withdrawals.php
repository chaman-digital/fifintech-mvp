<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/auth.php';

$user = authenticate();
if (!in_array($user['role'], ['superadmin', 'admin', 'subadmin'])) {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acceso denegado."]);
    exit;
}

$database = new Database();
$db = $database->getConnection();

try {
    $messages = [];
    
    // 1. Expand status enum
    try {
        $db->exec("ALTER TABLE transactions MODIFY COLUMN status enum('pending','completed','rejected') NOT NULL DEFAULT 'pending'");
        $messages[] = "Status enum expandido a 'rejected'.";
    } catch(PDOException $e) {
        $messages[] = "Status enum posiblemente ya modificado (" . $e->getMessage() . ").";
    }
    
    // 2. Add 'details' column
    try {
        $db->exec("ALTER TABLE transactions ADD COLUMN details JSON DEFAULT NULL AFTER status");
        $messages[] = "Columna 'details' agregada correctamente.";
    } catch(PDOException $e) {
        // En MySQL, si la columna ya existe tira error
        $messages[] = "Columna 'details' ya existe o hubo error (" . $e->getMessage() . ").";
    }

    echo json_encode([
        "status" => "success", 
        "message" => "Migración de Base de Datos procesada exitosamente.",
        "log" => $messages
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Error al migrar: " . $e->getMessage()]);
}
?>
