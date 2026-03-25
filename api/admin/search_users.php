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

require_once '../config/db.php';
require_once '../utils/auth.php';

// Verify admin role
requireAdmin();

$database = new Database();
$db = $database->getConnection();

$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';
$searchTerm = htmlspecialchars(strip_tags($searchTerm), ENT_QUOTES, 'UTF-8');

if (empty($searchTerm)) {
    http_response_code(400);
    echo json_encode(["message" => "Search term 'q' is required."]);
    exit;
}

$query = "
    SELECT 
        u.id, 
        u.firstName, 
        u.lastName, 
        u.email, 
        u.phone,
        up.publicUrl 
    FROM 
        users u 
    LEFT JOIN 
        user_profiles up ON u.id = up.userId
    WHERE 
        u.role = 'user' AND 
        (u.email LIKE :search 
        OR u.firstName LIKE :search 
        OR u.lastName LIKE :search 
        OR CONCAT(u.firstName, ' ', u.lastName) LIKE :search)
    ORDER BY u.firstName ASC
    LIMIT 20
";

$stmt = $db->prepare($query);

$searchParam = "%{$searchTerm}%";
$stmt->bindParam(":search", $searchParam);
$stmt->execute();

$users = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Sanitize output for XSS protection
    $users[] = [
        "id" => $row['id'],
        "firstName" => htmlspecialchars($row['firstName'], ENT_QUOTES, 'UTF-8'),
        "lastName" => htmlspecialchars($row['lastName'], ENT_QUOTES, 'UTF-8'),
        "email" => htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'),
        "phone" => htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8'),
        "publicUrl" => htmlspecialchars($row['publicUrl'], ENT_QUOTES, 'UTF-8')
    ];
}

http_response_code(200);
echo json_encode([
    "message" => "Search results.",
    "count" => count($users),
    "users" => $users
]);
?>