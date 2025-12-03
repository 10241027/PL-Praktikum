<h2>Daftar Minimarket</h2>
<a class="button" href="?c=minimarket&a=create">+ Tambah Minimarket</a>
<table>
<tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Kota</th><th>Kontak</th><th>Owner</th><th>Jarak (km)</th><th>Aksi</th></tr>
<?php foreach($data as $row): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['nama_minimarket']) ?></td>
    <td><?= htmlspecialchars($row['alamat']) ?></td>
    <td><?= htmlspecialchars($row['kota']) ?></td>
    <td><?= htmlspecialchars($row['no_hp']) ?></td>
    <td><?= htmlspecialchars($row['nama_owner']) ?></td>
    <td><?= htmlspecialchars($row['jarak_km']) ?></td>
    <td class="actions">
        <a class="button" href="?c=minimarket&a=edit&id=<?= $row['id'] ?>">Edit</a>
        <form method="POST" action="?c=minimarket&a=delete" style="display:inline;">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <button class="button danger" type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>