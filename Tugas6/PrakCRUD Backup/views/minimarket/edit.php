<style>
/* Placeholder merah */
input::placeholder {
    color: red;
    font-style: italic;
}
</style>

<?php
// Validasi Nama Minimarket di halaman Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $errors = [];

    $nama_minimarket = trim($_POST['nama_minimarket']);

    // Validasi wajib diisi
    if (empty($nama_minimarket)) {
        $errors[] = "Nama wajib diisi";
    }

    // Jika ada error, simpan ke session agar bisa ditampilkan di form
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: " . $_SERVER['PHP_SELF'] . "?c=minimarket&a=edit&id=" . $_POST['id']); // redirect kembali ke form edit
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

<h2>Edit Minimarket</h2>
<form method="POST" action="?c=minimarket&a=update">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <div class="form-row">
        <label>Nama Minimarket</label>
        <input type="text" name="nama_minimarket" value="<?= htmlspecialchars($item['nama_minimarket']) ?>" required placeholder="Nama wajib diisi">
    </div>
    <div class="form-row">
        <label>Lokasi</label>
        <select name="id_lokasi" required>
            <option value="">-- Pilih Lokasi --</option>
            <?php foreach($lokasi as $l): ?>
                <option value="<?= $l['id'] ?>" <?= $l['id']==$item['id_lokasi']? 'selected':'' ?>><?= htmlspecialchars($l['alamat'].' - '.$l['kota']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-row">
        <label>Kontak</label>
        <select name="id_kontak" required>
            <option value="">-- Pilih Kontak --</option>
            <?php foreach($kontak as $k): ?>
                <option value="<?= $k['id'] ?>" <?= $k['id']==$item['id_kontak']? 'selected':'' ?>><?= htmlspecialchars($k['no_hp']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-row">
        <label>Owner</label>
        <select name="id_owner" required>
            <option value="">-- Pilih Owner --</option>
            <?php foreach($owner as $o): ?>
                <option value="<?= $o['id'] ?>" <?= $o['id']==$item['id_owner']? 'selected':'' ?>><?= htmlspecialchars($o['nama_owner']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-row">
        <label>Jarak</label>
        <select name="id_jarak" required>
            <option value="">-- Pilih Jarak --</option>
            <?php foreach($jarak as $j): ?>
                <option value="<?= $j['id'] ?>" <?= $j['id']==$item['id_jarak']? 'selected':'' ?>><?= htmlspecialchars($j['jarak_km'].' km') ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="button" type="submit">Update</button>
</form>