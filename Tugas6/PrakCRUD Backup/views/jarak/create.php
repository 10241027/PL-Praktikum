<style>
/* Placeholder merah */
input::placeholder {
    color: red;
    font-style: italic;
}
</style>

<?php
// Validasi form Tambah Jarak
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $errors = [];

    $jarak_km = trim($_POST['jarak_km']);
    $deskripsi = trim($_POST['deskripsi']);

    // Validasi Jarak
    if (!is_numeric($jarak_km) || $jarak_km < 1) { 
        $errors[] = "Jarak minimal 1 km";
    }

    // Deskripsi opsional → tidak divalidasi

    // Jika ada error, simpan ke session agar bisa ditampilkan di form
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF']); // redirect kembali ke form
        exit;
    }

    // Jika lolos validasi, proses simpan ke database bisa ditambahkan di sini
}
?>

<?php if (isset($_SESSION['errors'])): ?>
    <div style="color:red;">
        <ul>
            <?php foreach ($_SESSION['errors'] as $err): ?>
                <li><?= htmlspecialchars($err); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<h2>Tambah Jarak</h2>
<form method="POST" action="?c=jarak&a=store">
    <div class="form-row">
        <label>Jarak (km)</label>
        <input type="text" name="jarak_km" required placeholder="Jarak minimal 1 km">
    </div>
    <div class="form-row">
        <label>Deskripsi</label>
        <input type="text" name="deskripsi" placeholder="Opsional">
    </div>
    <button class="button" type="submit">Simpan</button>
</form>