<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manajemen Minimarket</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="main-nav">
    <div class="nav-left">
        <a href="?c=minimarket&a=index">Minimarket</a>
        <a href="?c=lokasi&a=index">Lokasi</a>
        <a href="?c=kontak&a=index">Kontak</a>
        <a href="?c=owner&a=index">Owner</a>
        <a href="?c=jarak&a=index">Jarak</a>
    </div>
    <div class="nav-right">
        <?php
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (!empty($_SESSION['user'])) {
            $role = htmlspecialchars($_SESSION['user']['role']);
            echo "<span class=\"role-label\">" . ucfirst($role) . "</span> ";
            // show Feedback link for visitor
            if (($role) === 'visitor') {
                echo '<a href="?c=comment&a=index" class="button">Feedback</a> ';
            }
            // show Pending queue for admin
            if (($role) === 'admin') {
                echo '<a href="?c=pending&a=index" class="button">Pending</a> ';
            }
            echo '<a href="?c=auth&a=logout" class="button">Logout</a>';
        } else {
            echo '<a href="?c=auth&a=index" class="button">Login</a>';
        }
        ?>
    </div>
</nav>
<hr>
<div class="container">
<?php
if (session_status() == PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    $type = htmlspecialchars($flash['type'] ?? 'info');
    $message = $flash['message'] ?? '';
    echo "<div class=\"flash {$type}\">";
    if (is_array($message)) {
        echo '<ul style="margin:0;padding-left:18px;">';
        foreach ($message as $m) {
            echo '<li>' . htmlspecialchars($m) . '</li>';
        }
        echo '</ul>';
    } else {
        echo htmlspecialchars($message);
    }
    echo "</div>";
    unset($_SESSION['flash']);
}
?>
