<?php
require_once "config/database.php";
class Minimarket {
    private $conn;
    private $table = "minimarket";
    public function __construct(){ global $conn; $this->conn=$conn; }

    public function all(){
        $sql = "SELECT m.*, l.alamat AS alamat, l.kota AS kota, k.no_hp AS no_hp, o.nama_owner AS nama_owner, j.jarak_km AS jarak_km
                FROM minimarket m
                LEFT JOIN lokasi l ON m.id_lokasi = l.id
                LEFT JOIN kontak k ON m.id_kontak = k.id
                LEFT JOIN owner o ON m.id_owner = o.id
                LEFT JOIN jarak j ON m.id_jarak = j.id
                ORDER BY m.id DESC";
        $res = $this->conn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id){ $stmt=$this->conn->prepare("SELECT * FROM $this->table WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute(); return $stmt->get_result()->fetch_assoc(); }

    public function create($d){ $stmt=$this->conn->prepare("INSERT INTO $this->table (nama_minimarket,id_lokasi,id_kontak,id_owner,id_jarak) VALUES (?,?,?,?,?)"); $stmt->bind_param("siiii",$d['nama_minimarket'],$d['id_lokasi'],$d['id_kontak'],$d['id_owner'],$d['id_jarak']); return $stmt->execute(); }

    public function update($id,$d){ $stmt=$this->conn->prepare("UPDATE $this->table SET nama_minimarket=?,id_lokasi=?,id_kontak=?,id_owner=?,id_jarak=? WHERE id=?"); $stmt->bind_param("siiiii",$d['nama_minimarket'],$d['id_lokasi'],$d['id_kontak'],$d['id_owner'],$d['id_jarak'],$id); return $stmt->execute(); }

    public function delete($id){ $stmt=$this->conn->prepare("DELETE FROM $this->table WHERE id=?"); $stmt->bind_param("i",$id); return $stmt->execute(); }
}
?>