<?php
require_once __DIR__ . '/../config/db.php';
$database = new Database();
$db = $database->getConnection();

try {
    $db->exec("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'completed', 'rejected') NOT NULL DEFAULT 'pending'");
    $db->exec("ALTER TABLE transactions ADD COLUMN details JSON DEFAULT NULL");
    echo "Exito";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
