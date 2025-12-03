<style>
/* Placeholder merah */
input::placeholder {
    color: red;
    font-style: italic;
}
</style>

<?php
// Validasi form Edit Owner
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $errors = [];

    $nama_owner = trim($_POST['nama_owner']);
    $nik = trim($_POST['nik']);

    // Validasi Nama Owner
    if (empty($nama_owner)) {
        $errors[] = "Nama Owner wajib diisi";
    }

    // Validasi NIK
    if (empty($nik)) {
        $errors[] = "NIK wajib diisi";
    } elseif (strlen(preg_replace('/\D/', '', $nik)) < 8) { // hanya menghitung digit
        $errors[] = "NIK minimal 8 digit";
    }

    // Jika ada error, simpan ke session agar bisa ditampilkan di form
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF'] . "?c=owner&a=edit&id=" . $_POST['id']); // redirect kembali ke form edit
        exit;
    }

    // Jika lolos validasi, proses update ke database bisa ditambahkan di sini
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

<h2>Edit Owner</h2>
<form method="POST" action="?c=owner&a=update">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <div class="form-row">
        <label>Nama Owner</label>
        <input type="text" name="nama_owner" value="<?= htmlspecialchars($item['nama_owner']) ?>" required placeholder="Nama Owner wajib diisi">
    </div>
    <div class="form-row">
        <label>NIK</label>
        <input type="text" name="nik" value="<?= htmlspecialchars($item['nik']) ?>" required placeholder="NIK wajib diisi minimal 8 digit">
    </div>
    <button class="button" type="submit">Update</button>
</form>