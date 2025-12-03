<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../helpers/Csrf.php';
$token = Csrf::generateToken();
?>
<h2>Feedback / Komentar</h2>

<section>
    <h3>Komentar yang sudah disetujui</h3>
    <?php if (empty($approved)): ?>
        <p>Belum ada komentar.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($approved as $c): ?>
                <li><strong><?php echo htmlspecialchars($c['username'] ?? 'Anon'); ?></strong>: <?php echo htmlspecialchars($c['comment_text']); ?> <em style="color:#777;font-size:0.9em">(<?php echo $c['created_at']; ?>)</em></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<section>
    <h3>Kirim komentar (Visitor)</h3>
    <?php
    $user = $_SESSION['user'] ?? null;
    if (!$user || ($user['role'] ?? '') !== 'visitor') {
        echo '<p>Anda harus login sebagai <strong>visitor</strong> untuk mengirim komentar.</p>';
    } else {
    ?>
    <form method="post" action="?c=comment&a=store">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
        <div>
            <textarea name="comment_text" rows="4" style="width:100%" required></textarea>
        </div>
        <div>
            <button class="button" type="submit">Kirim komentar</button>
        </div>
    </form>
    <?php } ?>
</section>
