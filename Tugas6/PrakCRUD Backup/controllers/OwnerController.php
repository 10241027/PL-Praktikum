<?php
require_once "models/Owner.php";
class OwnerController {
    private $model;
    public function __construct(){ $this->model = new Owner(); }
    public function index(){ $data = $this->model->all(); include "views/layout/header.php"; include "views/owner/index.php"; include "views/layout/footer.php"; }
    public function create(){ include "views/layout/header.php"; include "views/owner/create.php"; include "views/layout/footer.php"; }
    public function store(){ $this->model->create($_POST); header("Location: ?c=owner&a=index"); }
    public function edit(){ $id = $_GET['id']; $item = $this->model->find($id); include "views/layout/header.php"; include "views/owner/edit.php"; include "views/layout/footer.php"; }
    public function update(){ $id = $_POST['id']; $this->model->update($id,$_POST); header("Location: ?c=owner&a=index"); }
    public function delete(){ $id = $_POST['id']; $this->model->delete($id); header("Location: ?c=owner&a=index"); }
}
?>