<?php

class Csrf {
    public static function generateToken() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }

    public static function verifyOrFail($token) {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $token) {
            http_response_code(403);
            die('CSRF token validation failed');
        }
    }
}

?>