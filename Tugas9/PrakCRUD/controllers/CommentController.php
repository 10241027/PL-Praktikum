<?php
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../models/Comment.php';

class CommentController {
    public function index(){
        // show feedback page: approved comments + form for visitor
        $approved = Comment::getApproved();
        include "views/layout/header.php";
        include "views/comment/index.php";
        include "views/layout/footer.php";
    }

    public function store(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
        if (session_status() == PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user || ($user['role'] ?? '') !== 'visitor') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Hanya visitor yang dapat mengirim komentar.'];
            header("Location: ?c=comment&a=index");
            exit;
        }
        $text = trim($_POST['comment_text'] ?? '');
        if ($text === '') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Komentar tidak boleh kosong.'];
            header("Location: ?c=comment&a=index");
            exit;
        }
        Comment::create($user['id'], $text);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Komentar dikirim dan menunggu persetujuan admin.'];
        header("Location: ?c=comment&a=index");
    }
}

?>
