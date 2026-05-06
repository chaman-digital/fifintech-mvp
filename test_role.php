<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'api/config/db.php';
$dbRole = new Database();
$db = $dbRole->getConnection();
if ($db) {
    $stmt = $db->query("SELECT email, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($users);
    echo "</pre>";
} else {
    echo "No DB connection\n";
}
