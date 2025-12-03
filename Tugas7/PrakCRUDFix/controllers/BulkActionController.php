<?php

require_once __DIR__ . '/../models/Repository.php';

class BulkActionController {
    public function handleBulkAction($ids, $action) {
        $repository = new Repository();

        if ($action === 'restore') {
            $repository->restoreBulk($ids);
        } elseif ($action === 'delete') {
            $repository->forceDeleteBulk($ids);
        } else {
            throw new Exception('Invalid action');
        }
    }
}

?>