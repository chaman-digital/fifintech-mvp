<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'config/db.php';
require_once 'utils/jwt.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (empty($data->email) || empty($data->password)) {
    http_response_code(400);
    echo json_encode(["message" => "Email and password are required."]);
    exit;
}

$email = filter_var($data->email, FILTER_SANITIZE_EMAIL);

$query = "SELECT id, firstName, lastName, phone, email, role, password FROM users WHERE email = :email LIMIT 1";
$stmt = $db->prepare($query);

$stmt->bindParam(":email", $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $password_hash = $row['password'];

   if (password_verify($data->password, $password_hash) || $data->password === $password_hash) {
        $token_payload = [
            "id" => $row['id'],
            "email" => $row['email'],
            "role" => $row['role'],
            "name" => htmlspecialchars($row['firstName'] . ' ' . $row['lastName'], ENT_QUOTES, 'UTF-8')
        ];

        $jwt = JWT::encode($token_payload);

        http_response_code(200);
        echo json_encode([
            "message" => "Login successful.",
            "token" => $jwt,
            "user" => [
                "id" => $row['id'],
                "firstName" => $row['firstName'],
                "lastName" => $row['lastName'],
                "email" => $row['email'],
                "phone" => $row['phone'], // <-- LÍNEA NUEVA
                "role" => $row['role']
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Invalid credentials."]);
    }
} else {
    http_response_code(401);
    echo json_encode(["message" => "Invalid credentials."]);
}
?>