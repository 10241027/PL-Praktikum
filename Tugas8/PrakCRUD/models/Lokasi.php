<?php
require_once "config/database.php";
class Lokasi {
    private $conn;
    private $table = "lokasi";
    public function __construct(){ global $conn; $this->conn=$conn; }
    public function all(){ $q=$this->conn->query("SELECT * FROM $this->table"); return $q->fetch_all(MYSQLI_ASSOC); }
    public function find($id){ $stmt=$this->conn->prepare("SELECT * FROM $this->table WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute(); return $stmt->get_result()->fetch_assoc(); }
    public function create($d){ $stmt=$this->conn->prepare("INSERT INTO $this->table (alamat,kota,provinsi) VALUES (?,?,?)"); $stmt->bind_param("sss",$d['alamat'],$d['kota'],$d['provinsi']); return $stmt->execute(); }
    public function update($id,$d){ $stmt=$this->conn->prepare("UPDATE $this->table SET alamat=?,kota=?,provinsi=? WHERE id=?"); $stmt->bind_param("sssi",$d['alamat'],$d['kota'],$d['provinsi'],$id); return $stmt->execute(); }
    public function delete($id){ $stmt=$this->conn->prepare("DELETE FROM $this->table WHERE id=?"); $stmt->bind_param("i",$id); return $stmt->execute(); }
}
?>