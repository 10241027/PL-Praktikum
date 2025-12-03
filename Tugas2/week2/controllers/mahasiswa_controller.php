<?php
$mahasiswa = [
    ["nim" => "2101001", "nama" => "Huang", "jurusan" => "Informatika"],
    ["nim" => "10241027", "nama" => "Fabyo", "jurusan" => "Sistem Informasi"],
    ["nim" => "10241035", "nama" => "Hamzah", "jurusan" => "Sistem Informasi"],
    ["nim" => "10241071", "nama" => "Toro", "jurusan" => "Sistem Informasi"],
    ["nim" => "10241039", "nama" => "Linggar", "jurusan" => "Sistem Informasi"],
    ["nim" => "10241047", "nama" => "Farras", "jurusan" => "Sistem Informasi"],
    ["nim" => "10241170", "nama" => "Rifat", "jurusan" => "Informatika"],
];

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim($_POST['nim'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jurusan = trim($_POST['jurusan'] ?? '');

    if ($nim === '') {
        $errors['nim'] = 'NIM wajib diisi.';
    }
    if ($nama === '') {
        $errors['nama'] = 'Nama wajib diisi.';
    }
    if ($jurusan === '') {
        $errors['jurusan'] = 'Jurusan wajib diisi.';
    }

    if (empty($errors)) {
        $mahasiswa[] = [
            'nim' => $nim,
            'nama' => $nama,
            'jurusan' => $jurusan,
        ];
    }
}

require __DIR__ . '/../views/mahasiswa_view.php';
?>