<?php
require_once "models/Minimarket.php";
require_once "models/Lokasi.php";
require_once "models/Kontak.php";
require_once "models/Owner.php";
require_once "models/Jarak.php";

class RestoreController {

    public function index(){
        // ambil semua data yang dihapus
        $minimarket = (new Minimarket())->allDeleted();
        $lokasi = (new Lokasi())->allDeleted();
        $kontak = (new Kontak())->allDeleted();
        $owner = (new Owner())->allDeleted();
        $jarak = (new Jarak())->allDeleted();

        include "views/layout/header.php";
        include "views/restore/index.php";
        include "views/layout/footer.php";
    }

    public function restore(){
        $id = $_POST['id'];
        $entity = $_POST['entity'];

        switch($entity){
            case 'minimarket': (new Minimarket())->restore($id); break;
            case 'lokasi': (new Lokasi())->restore($id); break;
            case 'kontak': (new Kontak())->restore($id); break;
            case 'owner': (new Owner())->restore($id); break;
            case 'jarak': (new Jarak())->restore($id); break;
        }
        header("Location: ?c=restore&a=index");
    }
}
?>