<?php
require_once "models/Jarak.php";
require_once __DIR__ . '/../helpers/Csrf.php';

class JarakController {
    private $model;
    public function __construct(){ $this->model = new Jarak(); }
    public function index(){ $data = $this->model->all(); include "views/layout/header.php"; include "views/jarak/index.php"; include "views/layout/footer.php"; }
    public function create(){ include "views/layout/header.php"; include "views/jarak/create.php"; include "views/layout/footer.php"; }
    public function store(){ Csrf::verifyOrFail($_POST['csrf_token'] ?? null); $this->model->create($_POST); if (session_status()==PHP_SESSION_NONE) session_start(); $_SESSION['flash']=['type'=>'success','message'=>'Jarak berhasil dibuat.']; header("Location: ?c=jarak&a=index"); }
    public function edit(){ $id = $_GET['id']; $item = $this->model->find($id); include "views/layout/header.php"; include "views/jarak/edit.php"; include "views/layout/footer.php"; }
    public function update(){ Csrf::verifyOrFail($_POST['csrf_token'] ?? null); $id = $_POST['id']; $this->model->update($id,$_POST); if (session_status()==PHP_SESSION_NONE) session_start(); $_SESSION['flash']=['type'=>'success','message'=>'Jarak berhasil diupdate.']; header("Location: ?c=jarak&a=index"); }
    public function delete(){ Csrf::verifyOrFail($_POST['csrf_token'] ?? null); $id = $_POST['id']; $this->model->delete($id); if (session_status()==PHP_SESSION_NONE) session_start(); $_SESSION['flash']=['type'=>'success','message'=>'Jarak berhasil dihapus.']; header("Location: ?c=jarak&a=index"); }
}
?>