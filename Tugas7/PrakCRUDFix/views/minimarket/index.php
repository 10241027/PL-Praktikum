<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8fafc;
        color: #333;
        margin: 0;
        padding: 0;
    }

    h2 {
        color: #0a3d62;
        text-align: center;
        margin-bottom: 15px;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 20px auto;
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 20px;
    }

    .toolbar form {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        width: 100%;
    }

    .toolbar input[type="text"] {
        flex: 1;
        min-width: 300px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
    }

    .toolbar select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        background-color: white;
        margin-left: 10px;
    }

    .toolbar button {
        padding: 8px 14px;
        border: none;
        background-color: #27ae60;
        color: white;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .toolbar button:hover {
        background-color: #219150;
    }

    .button {
        display: inline-block;
        background-color: #1e90ff;
        color: white;
        padding: 6px 12px;
        margin: 3px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        transition: 0.2s ease-in-out;
    }

    .button:hover {
        background-color: #0d6efd;
    }

    .button.danger {
        background-color: #e74c3c;
    }

    .button.danger:hover {
        background-color: #c0392b;
    }

    .sort-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sort-buttons {
        display: inline-flex;
        gap: 5px;
    }

    .sort-buttons .button {
        background-color: #6c5ce7;
        padding: 6px 10px;
        font-size: 13px;
    }

    .sort-buttons .button:hover {
        background-color: #4834d4;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th {
        background-color: #1e90ff;
        color: white;
        padding: 10px;
        text-align: left;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .actions {
        text-align: center;
    }

    .pagination {
        margin-top: 15px;
        text-align: center;
    }

    .pagination span {
        margin: 0 8px;
        font-weight: bold;
    }

    .bulk-actions {
        margin: 20px 0;
        text-align: center;
    }

    .bulk-actions form {
        display: inline-block;
        background-color: #f1f1f1;
        padding: 10px;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .bulk-actions input[type="checkbox"] {
        margin-right: 10px;
    }

    .bulk-actions button {
        padding: 8px 12px;
        border: none;
        background-color: #3498db;
        color: white;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
        margin-left: 5px;
    }

    .bulk-actions button:hover {
        background-color: #2980b9;
    }
</style>

<?php
require_once __DIR__ . '/../../helpers/Csrf.php';
$csrf = Csrf::generateToken();
?>

<div class="">
    <div class="toolbar">
        <form method="GET">
            <input type="hidden" name="c" value="minimarket">
            <input type="hidden" name="a" value="index">

            <input type="text" name="q" placeholder="Cari nama / alamat / kota..." 
                   value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">

            <div class="sort-group">
                <select name="sort">
                    <option value="">Urutkan berdasarkan</option>
                    <option value="nama_minimarket" <?= (isset($_GET['sort']) && $_GET['sort']=='nama_minimarket') ? 'selected' : '' ?>>Nama</option>
                    <option value="kota" <?= (isset($_GET['sort']) && $_GET['sort']=='kota') ? 'selected' : '' ?>>Kota</option>
                    <option value="jarak_km" <?= (isset($_GET['sort']) && $_GET['sort']=='jarak_km') ? 'selected' : '' ?>>Jarak (km)</option>
                </select>

                <div class="sort-buttons">
                    <?php
                    $currentSort = isset($_GET['sort']) ? $_GET['sort'] : '';
                    $q = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';
                    $currentOrder = isset($_GET['order']) ? strtolower($_GET['order']) : '';
                    ?>
                    <a href="?c=minimarket&a=index&sort=<?= $currentSort ?>&order=asc&q=<?= $q ?>" 
                       class="button <?= $currentOrder==='asc'?'active':'' ?>">🔼</a>
                    <a href="?c=minimarket&a=index&sort=<?= $currentSort ?>&order=desc&q=<?= $q ?>" 
                       class="button <?= $currentOrder==='desc'?'active':'' ?>">🔽</a>
                </div>
            </div>

            <button type="submit">🔍 Cari</button>
            <a href="?c=minimarket&a=index" class="button">🔄 Reset</a>
        </form>
    </div>

    <h2>Daftar Minimarket</h2>
    <a class="button" href="?c=minimarket&a=create">+ Tambah Minimarket</a>

    <?php
    if (isset($_GET['q']) && $_GET['q'] !== '') {
        $q = strtolower(trim($_GET['q']));
        $data = array_filter($data, function($item) use ($q) {
            return (
                strpos(strtolower($item['nama_minimarket']), $q) !== false ||
                strpos(strtolower($item['alamat']), $q) !== false ||
                strpos(strtolower($item['kota']), $q) !== false
            );
        });
    }

    if (isset($_GET['sort']) && $_GET['sort'] !== '') {
        $sort = $_GET['sort'];
        $order = (isset($_GET['order']) && strtolower($_GET['order']) === 'desc') ? 'desc' : 'asc';

        usort($data, function($a, $b) use ($sort, $order) {
            if (!isset($a[$sort]) || !isset($b[$sort])) return 0;
            if ($a[$sort] == $b[$sort]) return 0;
            if ($order === 'asc') return ($a[$sort] < $b[$sort]) ? -1 : 1;
            return ($a[$sort] > $b[$sort]) ? -1 : 1;
        });
    }

    $limit = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $limit;
    $total_data = count($data);
    $total_pages = ceil($total_data / $limit);
    $data_paginated = array_slice($data, $offset, $limit);
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Kontak</th>
            <th>Owner</th>
            <th>Jarak (km)</th>
            <th>Aksi</th>
        </tr>

        <?php foreach($data_paginated as $row): ?>
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
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <button class="button danger" type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

<?php if(!empty($dataDeleted)): ?>
    <h2 style="margin-top:40px; text-align:center;">Recycle Bin</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Kontak</th>
            <th>Owner</th>
            <th>Jarak (km)</th>
            <th>Aksi</th>
        </tr>
        <?php foreach($dataDeleted as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nama_minimarket']) ?></td>
            <td><?= htmlspecialchars($row['alamat']) ?></td>
            <td><?= htmlspecialchars($row['kota']) ?></td>
            <td><?= htmlspecialchars($row['no_hp']) ?></td>
            <td><?= htmlspecialchars($row['nama_owner']) ?></td>
            <td><?= htmlspecialchars($row['jarak_km']) ?></td>
            <td class="actions">
                <form method="POST" action="?c=minimarket&a=restore" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <button class="button" type="submit">Restore</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>


    <div class="pagination">
        <?php if ($page > 1): ?>
            <a class="button" href="?c=minimarket&a=index&page=<?= $page - 1 ?>">⟵ Sebelumnya</a>
        <?php endif; ?>

        <span>Halaman <?= $page ?> dari <?= $total_pages ?></span>

        <?php if ($page < $total_pages): ?>
            <a class="button" href="?c=minimarket&a=index&page=<?= $page + 1 ?>">Berikutnya ⟶</a>
        <?php endif; ?>
    </div>

    <?php if(!empty($dataDeleted)): ?>
    <div class="bulk-actions">
        <form method="POST" action="bulk_action.php" id="recycle-bulk-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
            <input type="checkbox" id="select_all_deleted" onclick="toggleDeletedCheckboxes(this)"> Select All
            <script>
                function toggleDeletedCheckboxes(source) {
                    const checkboxes = document.querySelectorAll('input[name="ids[]"]');
                    checkboxes.forEach(checkbox => checkbox.checked = source.checked);
                }
            </script>
            <!-- Dynamic checkboxes for recycle bin items -->
            <?php foreach($dataDeleted as $row): ?>
                <input type="checkbox" name="ids[]" value="<?= $row['id'] ?>"> <?= htmlspecialchars($row['nama_minimarket']) ?>
            <?php endforeach; ?>
            <button type="submit" name="action" value="restore">Restore Selected</button>
            <button type="submit" name="action" value="delete">Delete Selected</button>
        </form>
    </div>
    <?php else: ?>
    <!-- No deleted items, no bulk actions -->
    <?php endif; ?>
</div>