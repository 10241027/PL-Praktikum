<?php

require_once __DIR__ . '/../models/Repository.php';

class BulkActionController {
    public function handleBulkAction($ids, $action) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $repository = new Repository();

        if ($action === 'restore') {
            $affected = $repository->restoreBulk($ids);
            $_SESSION['flash'] = ['type' => 'success', 'message' => "$affected record(s) restored."];
            return $affected;
        } elseif ($action === 'delete') {
            $affected = $repository->forceDeleteBulk($ids);
            $_SESSION['flash'] = ['type' => 'success', 'message' => "$affected record(s) permanently deleted."];
            return $affected;
        } else {
            throw new Exception('Invalid action');
        }
    }
}

?>