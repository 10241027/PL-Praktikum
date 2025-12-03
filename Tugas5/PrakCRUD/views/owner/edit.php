<h2>Edit Owner</h2>
<form method="POST" action="?c=owner&a=update">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <div class="form-row"><label>Nama Owner</label><input type="text" name="nama_owner" value="<?= htmlspecialchars($item['nama_owner']) ?>" required></div>
    <div class="form-row"><label>NIK</label><input type="text" name="nik" value="<?= htmlspecialchars($item['nik']) ?>" required></div>
    <button class="button" type="submit">Update</button>
</form>