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

    $alamat = trim($_POST['alamat']);
    $kota = trim($_POST['kota']);
    $provinsi = trim($_POST['provinsi']);

    if (empty($alamat)) {
        $errors[] = "Alamat wajib diisi";
    }
    if (empty($kota)) {
        $errors[] = "Kota wajib diisi";
    }
    if (empty($provinsi)) {
        $errors[] = "Provinsi wajib diisi";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF'] . "?c=lokasi&a=edit&id=" . $_POST['id']);
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

<h2>Edit Lokasi</h2>
<form method="POST" action="?c=lokasi&a=update">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <div class="form-row">
        <label>Alamat</label>
        <input type="text" name="alamat" value="<?= htmlspecialchars($item['alamat']) ?>" required placeholder="Alamat wajib diisi">
    </div>
    <div class="form-row">
        <label>Kota</label>
        <input type="text" name="kota" value="<?= htmlspecialchars($item['kota']) ?>" required placeholder="Kota wajib diisi">
    </div>
    <div class="form-row">
        <label>Provinsi</label>
        <input type="text" name="provinsi" value="<?= htmlspecialchars($item['provinsi']) ?>" required placeholder="Provinsi wajib diisi">
    </div>
    <button class="button" type="submit">Update</button>
</form>