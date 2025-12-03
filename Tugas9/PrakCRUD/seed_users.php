<?php
// Simple user seeder: creates users table and inserts three accounts: admin, surveyor, visitor
// ensure DB connection is available
if (!isset($conn) || !$conn) {
    $dbFile = __DIR__ . '/config/database.php';
    if (file_exists($dbFile)) require_once $dbFile;
}
if (!isset($conn) || !$conn) {
    // fallback: create a direct mysqli connection
    $conn = new mysqli('localhost','root','','minimarket');
}

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(200) DEFAULT '',
    role VARCHAR(50) DEFAULT 'visitor',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$conn->query($sql);

$accounts = [
    ['username'=>'admin','password'=>'password','name'=>'Administrator','role'=>'admin'],
    ['username'=>'surveyor','password'=>'password','name'=>'Surveyor','role'=>'surveyor'],
    ['username'=>'visitor','password'=>'password','name'=>'Visitor','role'=>'visitor'],
];

$inserted = 0;
foreach($accounts as $a){
    // check exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param('s',$a['username']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->fetch_assoc()){
        continue;
    }
    $stmt->close();

    $hash = password_hash($a['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username,password,name,role) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $a['username'],$hash,$a['name'],$a['role']);
    if ($stmt->execute()) $inserted++;
    $stmt->close();
}

echo "Inserted $inserted user(s)\n";

?>