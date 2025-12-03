<?php
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function index(){
        // show login form
        include 'views/layout/header.php';
        include 'views/auth/login.php';
        include 'views/layout/footer.php';
    }

    public function login(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
        // normalize username to lowercase and trim to avoid case mismatch
        $username = isset($_POST['username']) ? strtolower(trim($_POST['username'])) : '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        // if users table is empty, run seeder to create sample accounts
        if ($userModel->countAll() === 0) {
            // seed_users.php creates admin/surveyor/visitor accounts
            $seedFile = __DIR__ . '/../seed_users.php';
            if (file_exists($seedFile)) require_once $seedFile;
        }
        $user = $userModel->findByUsername($username);
        if ($user && password_verify($password, $user['password'])){
            if (session_status() == PHP_SESSION_NONE) session_start();
            // store minimal user info
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'name' => $user['name'],
                'role' => $user['role']
            ];
            $_SESSION['flash'] = ['type'=>'success','message'=>'Login berhasil. Selamat datang, '.$user['name']];
            header('Location: ?c=minimarket&a=index');
            exit;
        } else {
            if (session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['flash'] = ['type'=>'error','message'=>'Username atau password salah.'];
            header('Location: ?c=auth&a=index');
            exit;
        }
    }

    public function logout(){
        if (session_status() == PHP_SESSION_NONE) session_start();
        unset($_SESSION['user']);
        $_SESSION['flash'] = ['type'=>'info','message'=>'Anda telah logout.'];
        header('Location: ?c=minimarket&a=index');
        exit;
    }
}

?>
