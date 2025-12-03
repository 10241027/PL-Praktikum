<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../helpers/Csrf.php';
$token = Csrf::generateToken();
?>
<h2>Halaman Pending (Admin)</h2>

<section>
    <h3>Pending Komentar</h3>
    <?php if (empty($pendingComments)): ?>
        <p>Tidak ada komentar pending.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($pendingComments as $pc): ?>
            <li>
                <strong><?php echo htmlspecialchars($pc['username'] ?? 'Anon'); ?></strong>: <?php echo htmlspecialchars($pc['comment_text']); ?>
                <form style="display:inline;margin-left:10px;" method="post" action="?c=pending&a=approve_comment">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
                    <input type="hidden" name="id" value="<?php echo $pc['id']; ?>">
                    <button class="button">Setujui</button>
                </form>
                <form style="display:inline;margin-left:6px;" method="post" action="?c=pending&a=reject_comment">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
                    <input type="hidden" name="id" value="<?php echo $pc['id']; ?>">
                    <button class="button">Tolak</button>
                </form>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<section>
    <h3>Pending Aksi Minimarket</h3>
    <?php if (empty($pendingMin)): ?>
        <p>Tidak ada aksi minimarket pending.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($pendingMin as $pm): ?>
            <li>
                <strong><?php echo htmlspecialchars($pm['username'] ?? 'Anon'); ?></strong>
                - Action: <?php echo htmlspecialchars($pm['action']); ?>
                (created: <?php echo $pm['created_at']; ?>)
                <div style="margin-top:4px;margin-bottom:6px;color:#333;">
                    Payload: <pre style="display:inline;background:#f6f6f6;padding:6px;border-radius:4px;"><?php echo htmlspecialchars($pm['payload']); ?></pre>
                </div>
                <form style="display:inline;margin-right:8px;" method="post" action="?c=pending&a=approve_minimarket">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
                    <input type="hidden" name="id" value="<?php echo $pm['id']; ?>">
                    <button class="button">Setujui</button>
                </form>
                <form style="display:inline;" method="post" action="?c=pending&a=reject_minimarket">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
                    <input type="hidden" name="id" value="<?php echo $pm['id']; ?>">
                    <button class="button">Tolak</button>
                </form>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
