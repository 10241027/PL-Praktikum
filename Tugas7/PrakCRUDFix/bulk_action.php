<?php

require_once __DIR__ . '/controllers/BulkActionController.php';
require_once __DIR__ . '/helpers/Csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $ids = $_POST['ids'] ?? [];
    $token = $_POST['csrf_token'] ?? null;

    // Verify CSRF token
    try {
        Csrf::verifyOrFail($token);
    } catch (Exception $e) {
        die('CSRF verification failed');
    }

    if (!is_array($ids) || empty($action)) {
        die('Invalid request');
    }

    try {
        $controller = new BulkActionController();
        $controller->handleBulkAction($ids, $action);
        header('Location: ' . $_SERVER['HTTP_REFERER']); // Redirect back to the same page
        exit;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    die('Invalid request method');
}

?>