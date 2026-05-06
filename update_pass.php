<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'api/config/db.php';
$dbRole = new Database();
$db = $dbRole->getConnection();
if ($db) {
    $email = 'rogeliovc800315@mail.com';
    $newPass = 'Inversion2026!';
    $hash = password_hash($newPass, PASSWORD_BCRYPT);
    $stmt = $db->prepare("UPDATE users SET password = :hash WHERE email = :email");
    $stmt->execute([':hash' => $hash, ':email' => $email]);
    echo "Password updated for $email.\n";
} else {
    echo "No DB connection\n";
}
