<h2>Data Lokasi</h2>
<a class="button" href="?c=lokasi&a=create">+ Tambah Lokasi</a>
<table>
<tr><th>ID</th><th>Alamat</th><th>Kota</th><th>Provinsi</th><th>Aksi</th></tr>
<?php foreach($data as $d): ?>
<tr>
    <td><?= $d['id'] ?></td>
    <td><?= htmlspecialchars($d['alamat']) ?></td>
    <td><?= htmlspecialchars($d['kota']) ?></td>
    <td><?= htmlspecialchars($d['provinsi']) ?></td>
    <td class="actions">
        <a class="button" href="?c=lokasi&a=edit&id=<?= $d['id'] ?>">Edit</a>
        <form method="POST" action="?c=lokasi&a=delete" style="display:inline;">
            <input type="hidden" name="id" value="<?= $d['id'] ?>">
            <button class="button danger" type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>