<?php
require_once "models/Kontak.php";
require_once __DIR__ . '/../helpers/Csrf.php';

class KontakController {
    private $model;
    public function __construct(){ $this->model = new Kontak(); }
    public function index(){ $data = $this->model->all(); include "views/layout/header.php"; include "views/kontak/index.php"; include "views/layout/footer.php"; }
    public function create(){ include "views/layout/header.php"; include "views/kontak/create.php"; include "views/layout/footer.php"; }
    public function store(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
    require_once __DIR__ . '/../models/Validator.php';
        $errors = [];
        if (!Validator::unique('kontak','email', $_POST['email'] ?? '')) {
            $errors[] = 'Email sudah terdaftar.';
        }
        if (!Validator::unique('kontak','no_hp', $_POST['no_hp'] ?? '')) {
            $errors[] = 'Nomor HP sudah terdaftar.';
        }
        if (!empty($errors)) {
            if (session_status()==PHP_SESSION_NONE) session_start();
            $_SESSION['flash'] = ['type'=>'error','message'=>$errors];
            header("Location: ?c=kontak&a=create");
            exit;
        }

        $this->model->create($_POST);
        if (session_status()==PHP_SESSION_NONE) session_start(); $_SESSION['flash'] = ['type'=>'success','message'=>'Kontak berhasil dibuat.']; header("Location: ?c=kontak&a=index"); }
    public function edit(){ $id = $_GET['id']; $item = $this->model->find($id); include "views/layout/header.php"; include "views/kontak/edit.php"; include "views/layout/footer.php"; }
    public function update(){
        Csrf::verifyOrFail($_POST['csrf_token'] ?? null);
        $id = $_POST['id'];
        require_once __DIR__ . '/../models/Validator.php';
        $errors = [];
        if (!Validator::unique('kontak','email', $_POST['email'] ?? '', $id)) {
            $errors[] = 'Email sudah terdaftar.';
        }
        if (!Validator::unique('kontak','no_hp', $_POST['no_hp'] ?? '', $id)) {
            $errors[] = 'Nomor HP sudah terdaftar.';
        }
        if (!empty($errors)) {
            if (session_status()==PHP_SESSION_NONE) session_start();
            $_SESSION['flash'] = ['type'=>'error','message'=>$errors];
            header("Location: ?c=kontak&a=edit&id={$id}");
            exit;
        }

        $this->model->update($id,$_POST);
        if (session_status()==PHP_SESSION_NONE) session_start(); $_SESSION['flash'] = ['type'=>'success','message'=>'Kontak berhasil diupdate.']; header("Location: ?c=kontak&a=index"); }
    public function delete(){ Csrf::verifyOrFail($_POST['csrf_token'] ?? null); $id = $_POST['id']; $this->model->delete($id); if (session_status()==PHP_SESSION_NONE) session_start(); $_SESSION['flash'] = ['type'=>'success','message'=>'Kontak berhasil dihapus.']; header("Location: ?c=kontak&a=index"); }
}
?>