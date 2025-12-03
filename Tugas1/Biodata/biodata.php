<?php 
$Nama = "Fabyo Nathanael Suoth";
$NIM = "10241027";
$Prodi = "Sistem Informasi";
$Fakultas = "Fakultas Sains dan Teknologi Informasi";
$Tahun_Lahir= 2007;
$Tahun_Sekarang= 2025;

$Usia = $Tahun_Sekarang - $Tahun_Lahir;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata</title>
    <link rel="stylesheet" href="data.css">
</head>
<body>
    <div class="center">
    <div class="container">        
        <a href="https://itk.ac.id" style="color: white; text-decoration: none;">Institut Teknologi Kalimantan</a>
    </div>
        <div class="card-nama">
            <div class="nama">
                <h2><?php echo "$Nama"; ?></h2>
            </div>
        </div>
        <div class="card-nim">
            <div class="nim">
                <h2><?php echo "$NIM"; ?></h2>
            </div>
        </div>
        <div class="card-prodi">
            <div class="prodi">
                <h2><?php echo "$Prodi"; ?></h2>
            </div>
        </div>
        <div class="card-fakultas">
            <div class="fakultas">
                <h2><?php echo "$Fakultas"; ?></h2>
            </div>
        </div>
        <div class="card-usia">
            <div class="usia">
                <h2><?php echo "$Usia Tahun"; ?></h2>
            </div>
        </div>
    </div>
</body>
</html>