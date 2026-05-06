<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'api/config/db.php';
$dbRole = new Database();
$db = $dbRole->getConnection();
if ($db) {
    // We can create the user using our own script or use the create_user API with the token.
}
