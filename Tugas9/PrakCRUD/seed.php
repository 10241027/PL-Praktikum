<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/DoctorFactory.php';
require_once __DIR__ . '/models/AppointmentFactory.php';

 $conn->query("CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200),
    email VARCHAR(200),
    phone VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

echo "Seeding patients...\n";
$patientIds = [];
for ($i=1;$i<=50;$i++){
    $name = "Patient $i";
    $email = "patient{$i}@example.com";
    $phone = '08' . str_pad(rand(10000000,99999999),8,'0',STR_PAD_LEFT);
    $stmt = $conn->prepare("INSERT INTO patients (name,email,phone) VALUES (?,?,?)");
    $stmt->bind_param('sss',$name,$email,$phone);
    $stmt->execute();
    $patientIds[] = $stmt->insert_id;
    $stmt->close();
}

echo "Inserted " . count($patientIds) . " patients\n";

echo "Seeding doctors...\n";
$doctorIds = [];
for ($i=1;$i<=20;$i++){
    $data = [
        'name' => "Dr. Doctor $i",
        'email' => "dr{$i}@hospital.com",
        'phone' => '08' . rand(10000000,99999999),
        'specialization' => (array) ['Cardiology','Dermatology','Pediatrics','General'][$i%4]
    ];
    $id = DoctorFactory::create($data);
    $doctorIds[] = $id;
}

echo "Inserted " . count($doctorIds) . " doctors\n";

echo "Seeding appointments...\n";
$appointments = 0;
for ($i=0;$i<100;$i++){
    
    $dayOffset = rand(1,30);
    $date = strtotime("+$dayOffset days");
    while (in_array(date('N',$date), [6,7])) {
        $dayOffset++;
        $date = strtotime("+$dayOffset days");
    }
    $hour = rand(8,16);
    $minute = (rand(0,1) == 0) ? 0 : 30;
    $start = date('Y-m-d H:i:s', strtotime(date('Y-m-d',$date) . " $hour:$minute:00"));
    $duration = rand(30,60);
    $pdata = [
        'patient_id' => $patientIds[array_rand($patientIds)],
        'doctor_id' => $doctorIds[array_rand($doctorIds)],
        'start_time' => $start,
        'duration_minutes' => $duration
    ];
    AppointmentFactory::create($pdata);
    $appointments++;
}

echo "Inserted $appointments appointments\n";

echo "Seeding complete.\n";

?>