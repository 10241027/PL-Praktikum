<h2>Edit Lokasi</h2>
<form method="POST" action="?c=lokasi&a=update">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <div class="form-row"><label>Alamat</label><input type="text" name="alamat" value="<?= htmlspecialchars($item['alamat']) ?>" required></div>
    <div class="form-row"><label>Kota</label><input type="text" name="kota" value="<?= htmlspecialchars($item['kota']) ?>" required></div>
    <div class="form-row"><label>Provinsi</label><input type="text" name="provinsi" value="<?= htmlspecialchars($item['provinsi']) ?>" required></div>
    <button class="button" type="submit">Update</button>
</form>