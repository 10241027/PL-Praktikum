<?php
require_once "models/Minimarket.php";
require_once "models/Lokasi.php";
require_once "models/Kontak.php";
require_once "models/Owner.php";
require_once "models/Jarak.php";

class MinimarketController {
    private $model;

    public function __construct(){ 
        $this->model = new Minimarket(); 
    }

    public function index(){
        $data = $this->model->allNotDeleted();
        $dataDeleted = $this->model->allDeleted(); // ambil data recycle bin
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
        $this->model->create($_POST);
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
        $id = $_POST['id'];
        $this->model->update($id,$_POST);
        header("Location: ?c=minimarket&a=index");
    }

    // Soft delete
    public function delete(){
        $id = $_POST['id'];
        $this->model->delete($id);
        header("Location: ?c=minimarket&a=index");
    }

    // Restore data
    public function restore(){
        $id = $_POST['id'];
        $this->model->restore($id);
        header("Location: ?c=minimarket&a=index");
    }
}
?>