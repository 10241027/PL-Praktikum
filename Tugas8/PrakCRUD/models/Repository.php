<?php

class Repository {
    public static function autoDeleteOld($days = 30) {
        $dateThreshold = date('Y-m-d H:i:s', strtotime("-{$days} days"));

    $dbFile = __DIR__ . '/../config/database.php';
        if (file_exists($dbFile)) {
            require_once $dbFile;
        }

        if (!isset($conn) || !$conn) {
            $db = new mysqli('localhost', 'root', '', 'minimarket');
        } else {
            $db = $conn;
        }

    $stmt = $db->prepare("DELETE FROM minimarket WHERE deleted_at IS NOT NULL AND deleted_at < ?");
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . ($db->error ?? 'unknown'));
        }
        $stmt->bind_param('s', $dateThreshold);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if (!isset($conn) || !$conn) {
            $db->close();
        }

        return $affected;
    }

    public function restoreBulk($ids) {
        if (empty($ids)) {
            throw new Exception('No IDs provided for restore');
        }

        $idList = implode(',', array_map('intval', $ids));
        $query = "UPDATE minimarket SET deleted_at = NULL WHERE id IN ($idList) AND deleted_at IS NOT NULL";

        
        $db = new mysqli('localhost', 'root', '', 'minimarket');
        if ($db->connect_error) {
            throw new Exception('Database connection failed: ' . $db->connect_error);
        }
        if (!$db->query($query)) {
            throw new Exception('Query failed: ' . $db->error);
        }
        $affected = $db->affected_rows;
        $db->close();
        return $affected;
    }

    public function forceDeleteBulk($ids) {
        if (empty($ids)) {
            throw new Exception('No IDs provided for delete');
        }

        $idList = implode(',', array_map('intval', $ids));
        $query = "DELETE FROM minimarket WHERE id IN ($idList) AND deleted_at IS NOT NULL";

        
        $db = new mysqli('localhost', 'root', '', 'minimarket');
        if ($db->connect_error) {
            throw new Exception('Database connection failed: ' . $db->connect_error);
        }
        if (!$db->query($query)) {
            throw new Exception('Query failed: ' . $db->error);
        }
        $affected = $db->affected_rows;
        $db->close();
        return $affected;
    }
}

?>