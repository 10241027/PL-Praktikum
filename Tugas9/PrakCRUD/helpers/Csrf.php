<?php

class Csrf {
    public static function generateToken() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify CSRF token. On failure, set a flash error and optionally redirect back.
     * @param string|null $token
     * @param bool $redirect If true, redirect back to HTTP_REFERER (if available) after setting flash.
     */
    public static function verifyOrFail($token, $redirect = true) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $token) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid CSRF token. Silakan coba lagi.'];
            if ($redirect && !empty($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            http_response_code(403);
            die('CSRF token validation failed');
        }
    }
}

?>