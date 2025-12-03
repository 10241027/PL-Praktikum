<?php

class Repository {
    public static function autoDeleteOld($days = 30) {
        $dateThreshold = date('Y-m-d H:i:s', strtotime("-{$days} days"));

        // Logic to delete records older than $dateThreshold
        // Example: DELETE FROM table WHERE created_at < $dateThreshold
    }

    public function restoreBulk($ids) {
        if (empty($ids)) {
            throw new Exception('No IDs provided for restore');
        }

        $idList = implode(',', array_map('intval', $ids));
        $query = "UPDATE minimarket SET deleted_at = NULL WHERE id IN ($idList) AND deleted_at IS NOT NULL";

        // Execute the query
        $db = new mysqli('localhost', 'root', '', 'minimarket');
        if ($db->connect_error) {
            throw new Exception('Database connection failed: ' . $db->connect_error);
        }
        if (!$db->query($query)) {
            throw new Exception('Query failed: ' . $db->error);
        }
        $db->close();
    }

    public function forceDeleteBulk($ids) {
        if (empty($ids)) {
            throw new Exception('No IDs provided for delete');
        }

        $idList = implode(',', array_map('intval', $ids));
        $query = "DELETE FROM minimarket WHERE id IN ($idList) AND deleted_at IS NOT NULL";

        // Execute the query
        $db = new mysqli('localhost', 'root', '', 'minimarket');
        if ($db->connect_error) {
            throw new Exception('Database connection failed: ' . $db->connect_error);
        }
        if (!$db->query($query)) {
            throw new Exception('Query failed: ' . $db->error);
        }
        $db->close();
    }
}

?>