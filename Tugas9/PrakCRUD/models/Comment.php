<?php
require_once __DIR__ . '/../config/database.php';

class Comment {
    private static $table = 'comments';

    public static function ensureTable(){
        global $conn;
        $sql = "CREATE TABLE IF NOT EXISTS `".self::$table."` (
            `id` int NOT NULL AUTO_INCREMENT,
            `user_id` int DEFAULT NULL,
            `comment_text` text NOT NULL,
            `status` varchar(20) DEFAULT 'pending',
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            `approved_by` int DEFAULT NULL,
            `approved_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $conn->query($sql);
    }

    public static function create($userId, $text){
        global $conn;
        self::ensureTable();
        $stmt = $conn->prepare("INSERT INTO `".self::$table."` (user_id, comment_text, status) VALUES (?,?, 'pending')");
        $stmt->bind_param("is", $userId, $text);
        return $stmt->execute();
    }

    public static function getApproved(){
        global $conn;
        self::ensureTable();
        $res = $conn->query("SELECT c.*, u.username FROM `".self::$table."` c LEFT JOIN users u ON c.user_id = u.id WHERE c.status='approved' ORDER BY c.created_at DESC");
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public static function getPending(){
        global $conn;
        self::ensureTable();
        $res = $conn->query("SELECT c.*, u.username FROM `".self::$table."` c LEFT JOIN users u ON c.user_id = u.id WHERE c.status='pending' ORDER BY c.created_at ASC");
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public static function approve($id, $adminId){
        global $conn;
        self::ensureTable();
        $stmt = $conn->prepare("UPDATE `".self::$table."` SET status='approved', approved_by=?, approved_at=NOW() WHERE id = ?");
        $stmt->bind_param("ii", $adminId, $id);
        return $stmt->execute();
    }

    public static function reject($id, $adminId){
        global $conn;
        self::ensureTable();
        $stmt = $conn->prepare("UPDATE `".self::$table."` SET status='rejected', approved_by=?, approved_at=NOW() WHERE id = ?");
        $stmt->bind_param("ii", $adminId, $id);
        return $stmt->execute();
    }
}

?>
