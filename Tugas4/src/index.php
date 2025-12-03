<?php
require_once __DIR__ . '/core/Autoloader.php';

use Models\Mahasiswa;

// Membuat instance mahasiswa
$m1 = new Mahasiswa("10231080", "haikal", "Informatika");
$m2 = new Mahasiswa("10231081", "aril", "Sistem Informasi");
$m3 = new Mahasiswa("10231082", "irpan", "teknik lantai");
$m4 = new Mahasiswa("10241027", "Fabyo", "Sistem Informasi");

// Tampilkan Header
echo "<h2>Demo OOP Lanjutan</h2>";
echo "Total Instance Person: " . \Models\Person::getJumlah() . "<br><br>";

// Tabel output
echo "<table border='1' cellpadding='5' cellspacing='0'>
<tr>
<th>ID</th><th>NIM</th><th>Nama</th><th>Role</th><th>Introduce()</th><th>Deskripsi</th>
</tr>";

$data = [$m1, $m2, $m3, $m4];
$id = 1;
foreach ($data as $m) {
    echo "<tr>
    <td>{$id}</td>
    <td>{$m->getNim()}</td>
    <td>{$m->getNama()}</td>
    <td>{$m->getRole()}</td>
    <td>{$m->introduce()}</td>
    <td>{$m->deskripsi()}</td>
    </tr>";
    $id++;
}
echo "</table>";

// Static counter
echo "<p>Total Counter: " . \Models\Person::getJumlah() . "</p>";
?>