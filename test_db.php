<?php
require_once 'api/config/db.php';
$db = Database::getConnection();
if ($db) {
    $stmt = $db->query("SELECT id, email, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($users);
} else {
    echo "No DB connection\n";
}
