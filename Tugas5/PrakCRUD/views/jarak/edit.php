<h2>Edit Jarak</h2>
<form method="POST" action="?c=jarak&a=update">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <div class="form-row"><label>Jarak (km)</label><input type="text" name="jarak_km" value="<?= htmlspecialchars($item['jarak_km']) ?>" required></div>
    <div class="form-row"><label>Deskripsi</label><input type="text" name="deskripsi" value="<?= htmlspecialchars($item['deskripsi']) ?>"></div>
    <button class="button" type="submit">Update</button>
</form>