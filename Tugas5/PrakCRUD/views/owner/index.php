<h2>Data Owner</h2>
<a class="button" href="?c=owner&a=create">+ Tambah Owner</a>
<table>
<tr><th>ID</th><th>Nama Owner</th><th>NIK</th><th>Aksi</th></tr>
<?php foreach($data as $d): ?>
<tr>
    <td><?= $d['id'] ?></td>
    <td><?= htmlspecialchars($d['nama_owner']) ?></td>
    <td><?= htmlspecialchars($d['nik']) ?></td>
    <td class="actions">
        <a class="button" href="?c=owner&a=edit&id=<?= $d['id'] ?>">Edit</a>
        <form method="POST" action="?c=owner&a=delete" style="display:inline;">
            <input type="hidden" name="id" value="<?= $d['id'] ?>">
            <button class="button danger" type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>