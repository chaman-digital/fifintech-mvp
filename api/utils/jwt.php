<?php
require_once __DIR__ . '/../config/config.php';

class JWT {
    public static function encode($payload) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload['exp'] = time() + (60 * 60 * 24); // Token expires in 24 hours
        $payload = json_encode($payload);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public static function decode($jwt) {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return false;
        }

        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = $parts;

        $signature = str_replace(['-', '_'], ['+', '/'], $base64UrlSignature);
        $signature = base64_decode($signature);

        $expectedSignature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);

        if (!hash_equals($expectedSignature, $signature)) {
            return false;
        }

        $payload = str_replace(['-', '_'], ['+', '/'], $base64UrlPayload);
        $payload = json_decode(base64_decode($payload), true);

        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false; // Token expired
        }

        return $payload;
    }
}
?>