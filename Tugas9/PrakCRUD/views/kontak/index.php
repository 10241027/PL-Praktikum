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
        min-width: 200px;
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
</style>

<?php
require_once __DIR__ . '/../../helpers/Csrf.php';
$csrf = Csrf::generateToken();
?>

<div class="">
    <div class="toolbar">
        <form method="GET">
            <input type="hidden" name="c" value="kontak">
            <input type="hidden" name="a" value="index">

            <input type="text" name="q" placeholder="Cari No HP / Email..." 
                   value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">

            <div class="sort-group">
                <select name="sort">
                    <option value="">Urutkan berdasarkan</option>
                    <option value="no_hp" <?= (isset($_GET['sort']) && $_GET['sort']=='no_hp') ? 'selected' : '' ?>>No HP</option>
                    <option value="email" <?= (isset($_GET['sort']) && $_GET['sort']=='email') ? 'selected' : '' ?>>Email</option>
                </select>

                <div class="sort-buttons">
                    <?php
                    $currentSort = isset($_GET['sort']) ? $_GET['sort'] : '';
                    $q = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';
                    $currentOrder = isset($_GET['order']) ? strtolower($_GET['order']) : '';
                    ?>
                    <a href="?c=kontak&a=index&sort=<?= $currentSort ?>&order=asc&q=<?= $q ?>" 
                       class="button <?= $currentOrder==='asc'?'active':'' ?>">🔼</a>
                    <a href="?c=kontak&a=index&sort=<?= $currentSort ?>&order=desc&q=<?= $q ?>" 
                       class="button <?= $currentOrder==='desc'?'active':'' ?>">🔽</a>
                </div>
            </div>

            <button type="submit">🔍 Cari</button>
            <a href="?c=kontak&a=index" class="button">🔄 Reset</a>
        </form>
    </div>

    <h2>Data Kontak</h2>
    <a class="button" href="?c=kontak&a=create">+ Tambah Kontak</a>

    <?php
    if (isset($_GET['q']) && $_GET['q'] !== '') {
        $q = strtolower(trim($_GET['q']));
        $data = array_filter($data, function($item) use ($q) {
            return strpos(strtolower($item['no_hp']), $q) !== false ||
                   strpos(strtolower($item['email']), $q) !== false;
        });
    }

    if (isset($_GET['sort']) && $_GET['sort'] !== '') {
        $sort = $_GET['sort'];
        $order = (isset($_GET['order']) && strtolower($_GET['order']) === 'desc') ? 'desc' : 'asc';
        usort($data, function($a, $b) use ($sort, $order) {
            if (!isset($a[$sort]) || !isset($b[$sort])) return 0;
            if ($a[$sort] == $b[$sort]) return 0;
            return ($order === 'asc') ? (($a[$sort] < $b[$sort]) ? -1 : 1) : (($a[$sort] > $b[$sort]) ? -1 : 1);
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
            <th>No HP</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        <?php foreach($data_paginated as $d): ?>
        <tr>
            <td><?= $d['id'] ?></td>
            <td><?= htmlspecialchars($d['no_hp']) ?></td>
            <td><?= htmlspecialchars($d['email']) ?></td>
            <td class="actions">
                <a class="button" href="?c=kontak&a=edit&id=<?= $d['id'] ?>">Edit</a>
                <form method="POST" action="?c=kontak&a=delete" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <button class="button danger" type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a class="button" href="?c=kontak&a=index&page=<?= $page - 1 ?>">⟵ Sebelumnya</a>
        <?php endif; ?>

        <span>Halaman <?= $page ?> dari <?= $total_pages ?></span>

        <?php if ($page < $total_pages): ?>
            <a class="button" href="?c=kontak&a=index&page=<?= $page + 1 ?>">Berikutnya ⟶</a>
        <?php endif; ?>
    </div>
</div>