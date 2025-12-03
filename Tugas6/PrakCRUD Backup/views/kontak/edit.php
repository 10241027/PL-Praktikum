<style>
/* Placeholder merah */
input::placeholder {
    color: red;
    font-style: italic;
}
</style>

<?php
// Validasi form Edit Kontak
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $errors = [];

    $no_hp = trim($_POST['no_hp']);
    $email = trim($_POST['email']);

    // Validasi No HP
    if (empty($no_hp)) {
        $errors[] = "Nomor HP wajib diisi";
    } elseif (strlen(preg_replace('/\D/', '', $no_hp)) < 10) { // menghitung digit saja
        $errors[] = "Nomor telepon minimal 10 digit";
    }

    // Validasi Email
    if (empty($email)) {
        $errors[] = "Email wajib diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }

    // Jika ada error, simpan ke session agar bisa ditampilkan di form
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF'] . "?c=kontak&a=edit&id=" . $_POST['id']); // redirect kembali ke form edit
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

<h2>Edit Kontak</h2>
<form method="POST" action="?c=kontak&a=update">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <div class="form-row">
        <label>No HP</label>
        <input type="text" name="no_hp" value="<?= htmlspecialchars($item['no_hp']) ?>" required placeholder="Nomor HP wajib diisi minimal 10 digit">
    </div>
    <div class="form-row">
        <label>Email</label>
        <input type="text" name="email" value="<?= htmlspecialchars($item['email']) ?>" required placeholder="Email wajib diisi dan format valid">
    </div>
    <button class="button" type="submit">Update</button>
</form>