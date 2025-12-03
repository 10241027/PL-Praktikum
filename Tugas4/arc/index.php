<?php
require_once __DIR__ . '/Core/Autoloader.php';

use Models\Mahasiswa;
use Models\Dosen;
use Models\AsistenDosen;

$m1 = new Mahasiswa("10241021", "Devin", "Sistem Informasi");
$m2 = new Mahasiswa("10241035", "Hamzah", "Sistem Informasi");
$m3 = new Mahasiswa("10241047", "Farras", "Sistem Informasi");
$m4 = new Mahasiswa("10241027", "Fabyo", "Sistem Informasi");

$d1 = new Dosen("D001", "Arif", "12345678", "Basis Data");
$d2 = new Dosen("D002", "Rosa", "87654321", "Pemrograman Lanjut");

$ad = new AsistenDosen("10231063", "Haikal", "Sistem Informasi", "Pemrograman Lanjut");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOP Lanjutan</title>
    <link rel="stylesheet" href="">
</head>
<body>
<div style="display: flex; justify-content: center; align-items: center; max-width: fit-content; min-width: 400px; margin: 15px auto; font-size: 15px; background-color: #007BFF; color: white; border: none; border-radius: 5px; box-sizing: border-box;">
<?php
echo "<h2>Demo OOP Lanjutan</h2>";
?>
</div>

<div style="display: flex; justify-content: center; align-items: center; max-width: fit-content; min-width: 500px; margin: 20px auto; font-size: 25px; background-color: #e0f243ff; color: white; border: none; border-radius: 5px; box-sizing: border-box;">
<?php
echo "Total Instance Person: " . \Models\Person::getJumlah();
?>
</div>

<div style="display: flex; justify-content: center;">
<?php
echo "<table border='1' cellpadding='5' cellspacing='0'>
<tr>
<th>ID</th><th>Nama</th><th>Role</th><th>Email</th><th>Introduce()</th><th>Deskripsi</th><th>Teach/Assistant</th>
</tr>";

$data = [$m1, $m2, $m3, $m4, $d1, $d2, $ad];
$id = 1;
foreach ($data as $obj) {
    $idValue = $obj instanceof Dosen ? $obj->getNim() : $obj->getNim();
    echo "<tr>
    <td>{$idValue}</td>
    <td>{$obj->getNama()}</td>
    <td>{$obj->getRole()}</td>
    <td>" . (method_exists($obj, 'getEmail') ? $obj->getEmail() : '-') . "</td>
    <td>" . (method_exists($obj, 'introduce') ? $obj->introduce() : '-') . "</td>
    <td>{$obj->deskripsi()}</td>
    <td>";
    if ($obj instanceof Dosen) {
        if ($obj->getNama() === "Arif") {
            echo $obj->teach("Basis Data");
        } elseif ($obj->getNama() === "Vika") {
            echo $obj->teach("Pemrograman Lanjut");
        } else {
            echo $obj->teach("Pemrograman Web");
        }
    } elseif ($obj instanceof AsistenDosen) {
        echo $obj->getAssistantRole();
    } else {
        echo "-";
    }
    echo "</td></tr>";
}
echo "</table>";
?>
</div>

<div style="display: flex; justify-content: center; align-items: center; max-width: fit-content; min-width: 200px; margin: 15px auto; font-size: 15px; background-color: #ec4e22ff; color: white; border: none; border-radius: 5px; box-sizing: border-box;">
<?php
echo "<p>Total Counter: " . \Models\Person::getJumlah() . "</p>";
?>
</div>

</body>
</html>