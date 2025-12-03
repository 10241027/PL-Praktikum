<?php
require_once __DIR__ . '/../config/database.php';

class PendingMinimarket {
    private static $table = 'pending_minimarkets';

    public static function ensureTable(){
        global $conn;
        $sql = "CREATE TABLE IF NOT EXISTS `".self::$table."` (
            `id` int NOT NULL AUTO_INCREMENT,
            `minimarket_id` int DEFAULT NULL,
            `action` varchar(20) NOT NULL,
            `payload` text,
            `created_by` int DEFAULT NULL,
            `status` varchar(20) DEFAULT 'pending',
            `reviewed_by` int DEFAULT NULL,
            `reviewed_at` datetime DEFAULT NULL,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $conn->query($sql);
    }

    public static function createPending($minimarketId, $action, $payload, $userId){
        global $conn;
        self::ensureTable();
        $json = json_encode($payload);
    $stmt = $conn->prepare("INSERT INTO `".self::$table."` (minimarket_id, action, payload, created_by) VALUES (?,?,?,?)");
    // types: minimarketId (i), action (s), payload (s), userId (i)
    $stmt->bind_param("issi", $minimarketId, $action, $json, $userId);
        return $stmt->execute();
    }

    public static function allPending(){
        global $conn;
        self::ensureTable();
        $res = $conn->query("SELECT p.*, u.username FROM `".self::$table."` p LEFT JOIN users u ON p.created_by = u.id WHERE p.status='pending' ORDER BY p.created_at ASC");
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public static function find($id){
        global $conn;
        self::ensureTable();
        $stmt = $conn->prepare("SELECT * FROM `".self::$table."` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function approve($id, $adminId){
        global $conn;
        self::ensureTable();
        $row = self::find($id);
        if (!$row) return false;
        $minModel = null;
        require_once __DIR__ . '/Minimarket.php';
        $minModel = new Minimarket();
        $payload = json_decode($row['payload'], true) ?: [];
        $ok = false;
        if ($row['action'] === 'create') {
            $ok = $minModel->create($payload);
        } elseif ($row['action'] === 'edit') {
            $mid = (int)$row['minimarket_id'];
            $ok = $minModel->update($mid, $payload);
        } elseif ($row['action'] === 'delete') {
            $mid = (int)$row['minimarket_id'];
            $ok = $minModel->delete($mid);
        }
        // update pending record
        $stmt = $conn->prepare("UPDATE `".self::$table."` SET status='approved', reviewed_by=?, reviewed_at=NOW() WHERE id = ?");
        $stmt->bind_param("ii", $adminId, $id);
        $stmt->execute();
        return $ok;
    }

    public static function reject($id, $adminId){
        global $conn;
        self::ensureTable();
        $stmt = $conn->prepare("UPDATE `".self::$table."` SET status='rejected', reviewed_by=?, reviewed_at=NOW() WHERE id = ?");
        $stmt->bind_param("ii", $adminId, $id);
        return $stmt->execute();
    }
}

?>
