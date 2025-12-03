<?php
require_once "config/database.php";
class Kontak {
    private $conn;
    private $table = "kontak";
    public function __construct(){ global $conn; $this->conn=$conn; }
    public function all(){ $q=$this->conn->query("SELECT * FROM $this->table"); return $q->fetch_all(MYSQLI_ASSOC); }
    public function find($id){ $stmt=$this->conn->prepare("SELECT * FROM $this->table WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute(); return $stmt->get_result()->fetch_assoc(); }
    public function create($d){ $stmt=$this->conn->prepare("INSERT INTO $this->table (no_hp,email) VALUES (?,?)"); $stmt->bind_param("ss",$d['no_hp'],$d['email']); return $stmt->execute(); }
    public function update($id,$d){ $stmt=$this->conn->prepare("UPDATE $this->table SET no_hp=?,email=? WHERE id=?"); $stmt->bind_param("ssi",$d['no_hp'],$d['email'],$id); return $stmt->execute(); }
    public function delete($id){ $stmt=$this->conn->prepare("DELETE FROM $this->table WHERE id=?"); $stmt->bind_param("i",$id); return $stmt->execute(); }
}
?>