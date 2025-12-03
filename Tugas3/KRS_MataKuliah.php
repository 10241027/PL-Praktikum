<?php

class MataKuliah {
    private $kode;
    private $nama;
    private $sks;
    public function __construct($kode, $nama, $sks) {
        $this->kode = $kode;
        $this->nama = $nama;
        $this->sks = $sks;
    }
    public function ringkas() {
        return "{$this->kode} - {$this->nama} ({$this->sks} SKS)";
    }
    public function getSks() {
        return $this->sks;
    }
    public function getKode() {
        return $this->kode;
    }
    public function getNama() {
        return $this->nama;
    }
}

class KRS {
    private $daftarMataKuliah;
    private $maxSks;
    public function __construct($maxSks = 24) {
        $this->daftarMataKuliah = [];
        $this->maxSks = $maxSks;
    }
    public function tambah(MataKuliah $mk) {
        $totalSksBaru = $this->totalSks() + $mk->getSks();
        if ($totalSksBaru > $this->maxSks) {
            return "Gagal menambahkan {$mk->getNama()}. Total SKS akan melebihi batas maksimal ({$this->maxSks} SKS).";
        }
        $this->daftarMataKuliah[] = $mk;
        return "Berhasil menambahkan {$mk->getNama()} ke KRS.";
    }
    public function totalSks() {
        $total = 0;
        foreach ($this->daftarMataKuliah as $mk) {
            $total += $mk->getSks();
        }
        return $total;
    }
    public function daftar() {
        if (empty($this->daftarMataKuliah)) {
            return "KRS masih kosong.";
        }
        $result = "Daftar Mata Kuliah dalam KRS:\n";
        foreach ($this->daftarMataKuliah as $index => $mk) {
            $result .= ($index + 1) . ". " . $mk->ringkas() . "\n";
        }
        return $result;
    }
    public function jumlahMataKuliah() {
        return count($this->daftarMataKuliah);
    }
}

// Mata kuliah
$mk1 = new MataKuliah("SI101", "Kewarganegaraan", 2);
$mk2 = new MataKuliah("SI102", "Matematika Diskrit 2", 3);
$mk3 = new MataKuliah("SI103", "Basis Data", 3);
$mk4 = new MataKuliah("SI104", "Desain dan Manajemen Jaringan Komputer", 4);
$mk5 = new MataKuliah("SI105", "Pemrograman Lanjut", 3);
$mk6 = new MataKuliah("SI106", "Desain Proses Bisnis", 4);
$mk7 = new MataKuliah("SI107", "Interaksi Manusia dan Komputer", 3);
$mk8 = new MataKuliah("SI108", "Statistika Sistem Informasi", 3);

$krs = new KRS(); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRS Mata Kuliah</title>
    <link rel="stylesheet" href="krsmatakuliah.css">
</head>
<body>

<div class="text">
<?php
echo "<h2>Sistem KRS - Kartu Rencana Studi</h2>";
?>
</div>

<div class="container1">
<div class="card1">
<?php
echo "<h3>Daftar Mata Kuliah yang Tersedia:</h3>";
$semuaMataKuliah = [$mk1, $mk2, $mk3, $mk4, $mk5, $mk6, $mk7, $mk8];

foreach ($semuaMataKuliah as $mk) {
    echo $mk->ringkas() . "<br>";
}
?>
</div>

<div class="card2">
<?php
echo "<h3>Proses Pengisian KRS:</h3>";
echo $krs->tambah($mk1) . "<br>"; 
echo $krs->tambah($mk2) . "<br>"; 
echo $krs->tambah($mk3) . "<br>"; 
echo $krs->tambah($mk4) . "<br>"; 
echo $krs->tambah($mk5) . "<br>"; 
echo $krs->tambah($mk6) . "<br>"; 
echo $krs->tambah($mk7) . "<br>"; 
echo "<strong>" . $krs->tambah($mk8) . "</strong><br>"; 
?>
</div>
</div>

<div class="container2">
<div class="card3">
<?php
echo "<h3>Hasil KRS:</h3>";
echo "<pre>" . $krs->daftar() . "</pre>";
?>
</div>

<div class="card4">
<?php
echo "<h3>Ringkasan:</h3>";
echo "Jumlah Mata Kuliah: " . $krs->jumlahMataKuliah() . "<br>";
echo "Total SKS: " . $krs->totalSks() . " / 24 SKS<br>";
?>
</div>
</div>

<div class="container3">
<div class="card5">
<?php
echo "<h3>Test dengan Batas SKS Berbeda (20 SKS):</h3>";
$krsKecil = new KRS(20);
echo $krsKecil->tambah($mk2) . "<br>";
echo $krsKecil->tambah($mk3) . "<br>";
echo $krsKecil->tambah($mk4) . "<br>";
echo $krsKecil->tambah($mk5) . "<br>";
echo $krsKecil->tambah($mk6) . "<br>"; 
echo $krsKecil->tambah($mk7) . "<br>"; 
?>
</div>

<div class="card6">
<?php
echo "<pre>" . $krsKecil->daftar() . "</pre>";
?>
</div>
</div>

<div class="container4">
<div class="card7">
<?php
echo "Total SKS KRS Kecil: " . $krsKecil->totalSks() . " / 20 SKS<br>";
?>
</div>
</div>

</body>
</html>