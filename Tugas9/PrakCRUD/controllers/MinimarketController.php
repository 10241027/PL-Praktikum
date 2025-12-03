<?php
require_once "models/Minimarket.php";
require_once "models/Lokasi.php";
require_once "models/Kontak.php";
require_once "models/Owner.php";
require_once "models/Jarak.php";
require_once __DIR__ . '/../helpers/Csrf.php';

class MinimarketController {
    private $model;

    public function __construct(){ 
        $this->model = new Minimarket(); 
    }

    public function index(){
        $data = $this->model->allNotDeleted();
        $dataDeleted = $this->model->allDeleted();
        include "views/layout/header.php";
        include "views/minimarket/index.php";
        include "views/layout/footer.php";
    }

    public function create(){
        $lokasi = (new Lokasi())->all();
        $kontak = (new Kontak())->all();
        $owner = (new Owner())->all();
        $jarak = (new Jarak())->all();
        include "views/layout/header.php";
        include "views/minimarket/create.php";
        include "views/layout/footer.php";
    }

    public function store(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
    require_once __DIR__ . '/../models/Validator.php';
        $errors = [];
        if (!Validator::unique('minimarket','nama_minimarket', $_POST['nama_minimarket'] ?? '')) {
            $errors[] = 'Nama minimarket sudah ada.';
        }
        if (!empty($errors)) {
            if (session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['flash'] = ['type' => 'error', 'message' => $errors];
            header("Location: ?c=minimarket&a=create");
            exit;
        }

        // if surveyor, create pending action instead of immediate create
        if (session_status() == PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if ($user && ($user['role'] ?? '') === 'surveyor') {
            require_once __DIR__ . '/../models/PendingMinimarket.php';
            $payload = $_POST;
            PendingMinimarket::createPending(null, 'create', $payload, $user['id']);
            $_SESSION['flash'] = ['type' => 'info', 'message' => 'Permintaan pembuatan minimarket telah dikirim dan menunggu persetujuan admin.'];
            header("Location: ?c=minimarket&a=index");
            exit;
        }

        $this->model->create($_POST);
        if (session_status() == PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Minimarket berhasil dibuat.'];
        header("Location: ?c=minimarket&a=index");
    }

    public function edit(){
        $id = $_GET['id'];
        $item = $this->model->find($id);
        $lokasi = (new Lokasi())->all();
        $kontak = (new Kontak())->all();
        $owner = (new Owner())->all();
        $jarak = (new Jarak())->all();
        include "views/layout/header.php";
        include "views/minimarket/edit.php";
        include "views/layout/footer.php";
    }

    public function update(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
        $id = $_POST['id'];
        require_once __DIR__ . '/../models/Validator.php';
        $errors = [];
        if (!Validator::unique('minimarket','nama_minimarket', $_POST['nama_minimarket'] ?? '', $id)) {
            $errors[] = 'Nama minimarket sudah ada.';
        }
        if (!empty($errors)) {
            if (session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['flash'] = ['type' => 'error', 'message' => $errors];
            header("Location: ?c=minimarket&a=edit&id={$id}");
            exit;
        }

        if (session_status() == PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if ($user && ($user['role'] ?? '') === 'surveyor') {
            require_once __DIR__ . '/../models/PendingMinimarket.php';
            $payload = $_POST;
            PendingMinimarket::createPending($id, 'edit', $payload, $user['id']);
            $_SESSION['flash'] = ['type' => 'info', 'message' => 'Permintaan perubahan minimarket telah dikirim dan menunggu persetujuan admin.'];
            header("Location: ?c=minimarket&a=index");
            exit;
        }

        $this->model->update($id,$_POST);
        if (session_status() == PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Minimarket berhasil diupdate.'];
        header("Location: ?c=minimarket&a=index");
    }

    public function delete(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
        $id = $_POST['id'];
        if (session_status() == PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if ($user && ($user['role'] ?? '') === 'surveyor') {
            require_once __DIR__ . '/../models/PendingMinimarket.php';
            PendingMinimarket::createPending($id, 'delete', [], $user['id']);
            $_SESSION['flash'] = ['type' => 'info', 'message' => 'Permintaan penghapusan minimarket telah dikirim dan menunggu persetujuan admin.'];
            header("Location: ?c=minimarket&a=index");
            exit;
        }

        $this->model->delete($id);
        if (session_status() == PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Minimarket dipindahkan ke Recycle Bin.'];
        header("Location: ?c=minimarket&a=index");
    }

    public function restore(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
        $id = $_POST['id'];
        $this->model->restore($id);
        if (session_status() == PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Minimarket berhasil dikembalikan.'];
        header("Location: ?c=minimarket&a=index");
    }
}
?>