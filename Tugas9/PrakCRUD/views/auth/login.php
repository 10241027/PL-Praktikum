<?php
require_once __DIR__ . '/../../helpers/Csrf.php';
$csrf = Csrf::generateToken();
?>

<h2>Login</h2>
<form method="POST" action="?c=auth&a=login" style="max-width:480px; margin:0 auto;">
    <div class="form-row">
        <label>Username</label>
        <input type="text" name="username" required>
    </div>
    <div class="form-row">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <button class="button" type="submit">Login</button>
</form>

<p style="text-align:center; margin-top:12px;">Akun contoh: admin / surveyor / visitor (password semua: <strong>password</strong>)</p>
