<h2>Data Kontak</h2>
<a class="button" href="?c=kontak&a=create">+ Tambah Kontak</a>
<table>
<tr><th>ID</th><th>No HP</th><th>Email</th><th>Aksi</th></tr>
<?php foreach($data as $d): ?>
<tr>
    <td><?= $d['id'] ?></td>
    <td><?= htmlspecialchars($d['no_hp']) ?></td>
    <td><?= htmlspecialchars($d['email']) ?></td>
    <td class="actions">
        <a class="button" href="?c=kontak&a=edit&id=<?= $d['id'] ?>">Edit</a>
        <form method="POST" action="?c=kontak&a=delete" style="display:inline;">
            <input type="hidden" name="id" value="<?= $d['id'] ?>">
            <button class="button danger" type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>