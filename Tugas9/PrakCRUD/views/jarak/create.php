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

    $jarak_km = trim($_POST['jarak_km']);
    $deskripsi = trim($_POST['deskripsi']);

    if (!is_numeric($jarak_km) || $jarak_km < 1) { 
        $errors[] = "Jarak minimal 1 km";
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

<?php
require_once __DIR__ . '/../../helpers/Csrf.php';
$csrf = Csrf::generateToken();
?>

<h2>Tambah Jarak</h2>
<form method="POST" action="?c=jarak&a=store">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
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