<?php
require_once "config/database.php";
class Owner {
    private $conn;
    private $table = "owner";
    public function __construct(){ global $conn; $this->conn=$conn; }
    public function all(){ $q=$this->conn->query("SELECT * FROM $this->table"); return $q->fetch_all(MYSQLI_ASSOC); }
    public function find($id){ $stmt=$this->conn->prepare("SELECT * FROM $this->table WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute(); return $stmt->get_result()->fetch_assoc(); }
    public function create($d){ $stmt=$this->conn->prepare("INSERT INTO $this->table (nama_owner,nik) VALUES (?,?)"); $stmt->bind_param("ss",$d['nama_owner'],$d['nik']); return $stmt->execute(); }
    public function update($id,$d){ $stmt=$this->conn->prepare("UPDATE $this->table SET nama_owner=?,nik=? WHERE id=?"); $stmt->bind_param("ssi",$d['nama_owner'],$d['nik'],$id); return $stmt->execute(); }
    public function delete($id){ $stmt=$this->conn->prepare("DELETE FROM $this->table WHERE id=?"); $stmt->bind_param("i",$id); return $stmt->execute(); }
}
?>