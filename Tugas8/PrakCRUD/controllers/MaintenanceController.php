<?php
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../models/Repository.php';

class MaintenanceController {
    public function autoDeleteOld() {
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);

        $days = isset($_POST['days']) ? (int)$_POST['days'] : 30;
        try {
            $affected = Repository::autoDeleteOld($days);
            if (session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['flash'] = ['type' => 'success', 'message' => "$affected record(s) permanently deleted from Recycle Bin."];
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?c=minimarket&a=index'));
            exit;
        } catch (Exception $e) {
            if (session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Auto-delete failed: ' . $e->getMessage()];
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?c=minimarket&a=index'));
            exit;
        }
    }
}

?>