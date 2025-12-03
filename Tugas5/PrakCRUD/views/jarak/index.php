<h2>Data Jarak</h2>
<a class="button" href="?c=jarak&a=create">+ Tambah Jarak</a>
<table>
<tr><th>ID</th><th>Jarak (km)</th><th>Deskripsi</th><th>Aksi</th></tr>
<?php foreach($data as $d): ?>
<tr>
    <td><?= $d['id'] ?></td>
    <td><?= htmlspecialchars($d['jarak_km']) ?></td>
    <td><?= htmlspecialchars($d['deskripsi']) ?></td>
    <td class="actions">
        <a class="button" href="?c=jarak&a=edit&id=<?= $d['id'] ?>">Edit</a>
        <form method="POST" action="?c=jarak&a=delete" style="display:inline;">
            <input type="hidden" name="id" value="<?= $d['id'] ?>">
            <button class="button danger" type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>