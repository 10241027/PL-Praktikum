<?php
require_once __DIR__ . '/config/database.php';

header('Content-Type: text/html; charset=utf-8');

echo '<h2>Daftar users di database minimarket</h2>';

if (!isset($conn) || !$conn) {
    echo '<p style="color:red;">Koneksi database tidak tersedia.</p>';
    exit;
}

$res = $conn->query("SELECT id, username, name, role, created_at FROM users ORDER BY id");
if (!$res) {
    echo '<p style="color:red;">Tabel users kosong atau terjadi error: ' . htmlspecialchars($conn->error) . '</p>';
    exit;
}

echo '<table border="1" cellpadding="6" cellspacing="0">';
echo '<tr><th>ID</th><th>Username</th><th>Name</th><th>Role</th><th>Created At</th></tr>';
while ($row = $res->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
    echo '<td>' . htmlspecialchars($row['username']) . '</td>';
    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
    echo '<td>' . htmlspecialchars($row['role']) . '</td>';
    echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
    echo '</tr>';
}
echo '</table>';

?>