<?php
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../models/PendingMinimarket.php';
require_once __DIR__ . '/../models/Comment.php';

class PendingController {
    public function index(){
        if (session_status() == PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            if (session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Hanya admin yang dapat mengakses halaman ini.'];
            header("Location: ?c=minimarket&a=index");
            exit;
        }
        $pendingMin = PendingMinimarket::allPending();
        $pendingComments = Comment::getPending();
        include "views/layout/header.php";
        include "views/pending/index.php";
        include "views/layout/footer.php";
    }

    public function approve_comment(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
        if (session_status() == PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Unauthorized'];
            header("Location: ?c=pending&a=index");
            exit;
        }
        $id = (int)($_POST['id'] ?? 0);
        Comment::approve($id, $user['id']);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Komentar disetujui.'];
        header("Location: ?c=pending&a=index");
    }

    public function reject_comment(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
        if (session_status() == PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Unauthorized'];
            header("Location: ?c=pending&a=index");
            exit;
        }
        $id = (int)($_POST['id'] ?? 0);
        Comment::reject($id, $user['id']);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Komentar ditolak.'];
        header("Location: ?c=pending&a=index");
    }

    public function approve_minimarket(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
        if (session_status() == PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Unauthorized'];
            header("Location: ?c=pending&a=index");
            exit;
        }
        $id = (int)($_POST['id'] ?? 0);
        PendingMinimarket::approve($id, $user['id']);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Aksi minimarket disetujui dan diterapkan.'];
        header("Location: ?c=pending&a=index");
    }

    public function reject_minimarket(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
        if (session_status() == PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Unauthorized'];
            header("Location: ?c=pending&a=index");
            exit;
        }
        $id = (int)($_POST['id'] ?? 0);
        PendingMinimarket::reject($id, $user['id']);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Aksi minimarket ditolak.'];
        header("Location: ?c=pending&a=index");
    }
}

?>
