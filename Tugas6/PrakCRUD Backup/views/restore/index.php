<h2 style="text-align:center; margin-top:30px;">Recycle Bin / Restore Data</h2>

<?php
$entities = [
    'Minimarket' => $minimarket,
    'Lokasi' => $lokasi,
    'Kontak' => $kontak,
    'Owner' => $owner,
    'Jarak' => $jarak
];

foreach($entities as $name => $rows):
?>
    <h3><?= $name ?></h3>
    <?php if(!empty($rows)): ?>
    <table>
        <tr>
            <?php foreach(array_keys($rows[0]) as $col): ?>
                <th><?= htmlspecialchars($col) ?></th>
            <?php endforeach; ?>
            <th>Aksi</th>
        </tr>
        <?php foreach($rows as $row): ?>
        <tr>
            <?php foreach($row as $val): ?>
                <td><?= htmlspecialchars($val) ?></td>
            <?php endforeach; ?>
            <td>
                <form method="POST" action="?c=restore&a=restore">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="entity" value="<?= strtolower($name) ?>">
                    <button class="button">Restore Data</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Tidak ada data <?= strtolower($name) ?> yang dihapus.</p>
    <?php endif; ?>
<?php endforeach; ?>