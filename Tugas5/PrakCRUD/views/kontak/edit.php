<h2>Edit Kontak</h2>
<form method="POST" action="?c=kontak&a=update">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <div class="form-row"><label>No HP</label><input type="text" name="no_hp" value="<?= htmlspecialchars($item['no_hp']) ?>" required></div>
    <div class="form-row"><label>Email</label><input type="text" name="email" value="<?= htmlspecialchars($item['email']) ?>" required></div>
    <button class="button" type="submit">Update</button>
</form>