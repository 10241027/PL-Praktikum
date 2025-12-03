<?php
require_once "models/Lokasi.php";
require_once __DIR__ . '/../helpers/Csrf.php';

class LokasiController {
    private $model;
    public function __construct(){ $this->model = new Lokasi(); }
    public function index(){ $data = $this->model->all(); include "views/layout/header.php"; include "views/lokasi/index.php"; include "views/layout/footer.php"; }
    public function create(){ include "views/layout/header.php"; include "views/lokasi/create.php"; include "views/layout/footer.php"; }
    public function store(){ Csrf::verifyOrFail($_POST['csrf_token'] ?? null); $this->model->create($_POST); if (session_status()==PHP_SESSION_NONE) session_start(); $_SESSION['flash']=['type'=>'success','message'=>'Lokasi berhasil dibuat.']; header("Location: ?c=lokasi&a=index"); }
    public function edit(){ $id = $_GET['id']; $item = $this->model->find($id); include "views/layout/header.php"; include "views/lokasi/edit.php"; include "views/layout/footer.php"; }
    public function update(){ Csrf::verifyOrFail($_POST['csrf_token'] ?? null); $id = $_POST['id']; $this->model->update($id,$_POST); if (session_status()==PHP_SESSION_NONE) session_start(); $_SESSION['flash']=['type'=>'success','message'=>'Lokasi berhasil diupdate.']; header("Location: ?c=lokasi&a=index"); }
    public function delete(){ Csrf::verifyOrFail($_POST['csrf_token'] ?? null); $id = $_POST['id']; $this->model->delete($id); if (session_status()==PHP_SESSION_NONE) session_start(); $_SESSION['flash']=['type'=>'success','message'=>'Lokasi berhasil dihapus.']; header("Location: ?c=lokasi&a=index"); }
}
?>