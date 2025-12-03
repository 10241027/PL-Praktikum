<?php

class DoctorFactory {
    public static function create($data) {
        $dbFile = __DIR__ . '/../config/database.php';
        if (file_exists($dbFile)) require_once $dbFile;
        global $conn;
        if (!isset($conn) || !$conn) {
            $conn = new mysqli('localhost', 'root', '', 'minimarket');
        }
        $conn->query("CREATE TABLE IF NOT EXISTS doctors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(200),
            email VARCHAR(200),
            phone VARCHAR(50),
            specialization VARCHAR(100),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $stmt = $conn->prepare("INSERT INTO doctors (name,email,phone,specialization) VALUES (?,?,?,?)");
        $name = $data['name'] ?? 'Dr. Unknown';
        $email = $data['email'] ?? 'no-reply@example.com';
        $phone = $data['phone'] ?? '';
        $spec = $data['specialization'] ?? '';
        $stmt->bind_param('ssss', $name, $email, $phone, $spec);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }

    public static function createMany($doctors) {
        foreach ($doctors as $data) {
            self::create($data);
        }
    }

    public static function createBySpecialization($specialization, $data) {
        $data['specialization'] = $specialization;
        self::create($data);
    }

    public static function createWithSchedule($data, $schedule) {
        $data['schedule'] = $schedule;
        return self::create($data);
    }
}

?>