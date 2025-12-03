<?php

class AppointmentFactory {
    public static function create($data) {
        $dbFile = __DIR__ . '/../config/database.php';
        if (file_exists($dbFile)) require_once $dbFile;
        global $conn;
        if (!isset($conn) || !$conn) {
            $conn = new mysqli('localhost', 'root', '', 'minimarket');
        }
        $conn->query("CREATE TABLE IF NOT EXISTS appointments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            patient_id INT,
            doctor_id INT,
            start_time DATETIME,
            duration_minutes INT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $stmt = $conn->prepare("INSERT INTO appointments (patient_id,doctor_id,start_time,duration_minutes) VALUES (?,?,?,?)");
        $pid = $data['patient_id'] ?? null;
        $did = $data['doctor_id'] ?? null;
        $start = $data['start_time'] ?? date('Y-m-d H:i:s');
        $dur = $data['duration_minutes'] ?? 30;
        $stmt->bind_param('iisi', $pid, $did, $start, $dur);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }

    public static function createMany($appointments) {
        foreach ($appointments as $data) {
            self::create($data);
        }
    }

    public static function createForPatient($patientId, $data) {
        $data['patient_id'] = $patientId;
        self::create($data);
    }

    public static function createForDoctor($doctorId, $data) {
        $data['doctor_id'] = $doctorId;
        self::create($data);
    }

    public static function createInRange($startDate, $endDate, $data) {
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $data['date'] = $currentDate;
            self::create($data);
            $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
        }
    }
}

?>