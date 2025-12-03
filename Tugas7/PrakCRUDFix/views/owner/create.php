<style>
input::placeholder {
    color: red;
    font-style: italic;
}
</style>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $errors = [];

    $nama_owner = trim($_POST['nama_owner']);
    $nik = trim($_POST['nik']);

    if (empty($nama_owner)) {
        $errors[] = "Nama Owner wajib diisi";
    }

    if (empty($nik)) {
        $errors[] = "NIK wajib diisi";
    } elseif (strlen(preg_replace('/\D/', '', $nik)) < 8) {
        $errors[] = "NIK minimal 8 digit";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

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

<h2>Tambah Owner</h2>
<form method="POST" action="?c=owner&a=store">
    <div class="form-row">
        <label>Nama Owner</label>
        <input type="text" name="nama_owner" required placeholder="Nama Owner wajib diisi">
    </div>
    <div class="form-row">
        <label>NIK</label>
        <input type="text" name="nik" required placeholder="NIK wajib diisi minimal 8 digit">
    </div>
    <button class="button" type="submit">Simpan</button>
</form>