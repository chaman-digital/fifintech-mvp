<?php
require_once __DIR__ . '/jwt.php';

function authenticate() {
    $headers = apache_request_headers();
    $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

    if (empty($authHeader)) {
        http_response_code(401);
        echo json_encode(['message' => 'Authorization header missing']);
        exit;
    }

    $token = str_replace('Bearer ', '', $authHeader);
    $payload = JWT::decode($token);

    if (!$payload) {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid or expired token']);
        exit;
    }

    return $payload;
}

function requireAdmin() {
    $user = authenticate();
    
    // Now both superadmin and subadmin are considered "admins" for general admin tasks
    if (!isset($user['role']) || !in_array($user['role'], ['superadmin', 'subadmin', 'admin'])) {
        http_response_code(403);
        echo json_encode(['message' => 'Forbidden. Admin role required.']);
        exit;
    }
    
    return $user;
}

function requireSuperAdmin() {
    $user = authenticate();
    
    // Explicitly require superadmin role
    if (!isset($user['role']) || $user['role'] !== 'superadmin') {
        http_response_code(403);
        echo json_encode(['message' => 'Forbidden. SuperAdmin role required.']);
        exit;
    }
    
    return $user;
}
?>