<?php
require_once "models/Lokasi.php";
class LokasiController {
    private $model;
    public function __construct(){ $this->model = new Lokasi(); }
    public function index(){ $data = $this->model->all(); include "views/layout/header.php"; include "views/lokasi/index.php"; include "views/layout/footer.php"; }
    public function create(){ include "views/layout/header.php"; include "views/lokasi/create.php"; include "views/layout/footer.php"; }
    public function store(){ $this->model->create($_POST); header("Location: ?c=lokasi&a=index"); }
    public function edit(){ $id = $_GET['id']; $item = $this->model->find($id); include "views/layout/header.php"; include "views/lokasi/edit.php"; include "views/layout/footer.php"; }
    public function update(){ $id = $_POST['id']; $this->model->update($id,$_POST); header("Location: ?c=lokasi&a=index"); }
    public function delete(){ $id = $_POST['id']; $this->model->delete($id); header("Location: ?c=lokasi&a=index"); }
}
?>