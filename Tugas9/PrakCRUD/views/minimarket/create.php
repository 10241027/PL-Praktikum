<style>
input::placeholder {
    color: red;
    font-style: italic;
}
</style>

<?php
require_once __DIR__ . '/../../helpers/Csrf.php';
$csrf = Csrf::generateToken();
?>

<h2>Tambah Minimarket</h2>
<form method="POST" action="?c=minimarket&a=store">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <div class="form-row">
        <label>Nama Minimarket</label>
        <input type="text" name="nama_minimarket" required placeholder="Nama wajib diisi">
    </div>
    <div class="form-row">
        <label>Lokasi</label>
        <select name="id_lokasi" required>
            <option value="">-- Pilih Lokasi --</option>
            <?php foreach($lokasi as $l): ?>
                <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['alamat'].' - '.$l['kota']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-row">
        <label>Kontak</label>
        <select name="id_kontak" required>
            <option value="">-- Pilih Kontak --</option>
            <?php foreach($kontak as $k): ?>
                <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['no_hp']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-row">
        <label>Owner</label>
        <select name="id_owner" required>
            <option value="">-- Pilih Owner --</option>
            <?php foreach($owner as $o): ?>
                <option value="<?= $o['id'] ?>"><?= htmlspecialchars($o['nama_owner']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-row">
        <label>Jarak</label>
        <select name="id_jarak" required>
            <option value="">-- Pilih Jarak --</option>
            <?php foreach($jarak as $j): ?>
                <option value="<?= $j['id'] ?>"><?= htmlspecialchars($j['jarak_km'].' km') ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="button" type="submit">Simpan</button>
</form>