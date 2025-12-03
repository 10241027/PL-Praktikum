<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table = 'users';

    public function __construct(){
        global $conn;
        $this->conn = $conn;
        // ensure users table exists to avoid prepare() errors
        $this->ensureTable();
    }

    private function ensureTable(){
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            name VARCHAR(200) DEFAULT '',
            role VARCHAR(50) DEFAULT 'visitor',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->conn->query($sql);
    }

    public function findByUsername($username){
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE username = ? LIMIT 1");
        if (!$stmt) {
            // prepare failed, return null
            return null;
        }
        $stmt->bind_param('s', $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function countAll(){
        $res = $this->conn->query("SELECT COUNT(*) AS c FROM {$this->table}");
        if (!$res) return 0;
        $r = $res->fetch_assoc();
        return (int) ($r['c'] ?? 0);
    }

    public function findById($id){
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data){
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (username,password,name,role) VALUES (?,?,?,?)");
        if (!$stmt) return false;
        $stmt->bind_param('ssss', $data['username'], $data['password'], $data['name'], $data['role']);
        return $stmt->execute();
    }
}

?>