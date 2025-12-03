<?php
require_once "config/database.php";
class Jarak {
    private $conn;
    private $table = "jarak";
    public function __construct(){ global $conn; $this->conn=$conn; }
    public function all(){ $q=$this->conn->query("SELECT * FROM $this->table"); return $q->fetch_all(MYSQLI_ASSOC); }
    public function find($id){ $stmt=$this->conn->prepare("SELECT * FROM $this->table WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute(); return $stmt->get_result()->fetch_assoc(); }
    public function create($d){ $stmt=$this->conn->prepare("INSERT INTO $this->table (jarak_km,deskripsi) VALUES (?,?)"); $stmt->bind_param("ds",$d['jarak_km'],$d['deskripsi']); return $stmt->execute(); }
    public function update($id,$d){ $stmt=$this->conn->prepare("UPDATE $this->table SET jarak_km=?,deskripsi=? WHERE id=?"); $stmt->bind_param("dsi",$d['jarak_km'],$d['deskripsi'],$id); return $stmt->execute(); }
    public function delete($id){ $stmt=$this->conn->prepare("DELETE FROM $this->table WHERE id=?"); $stmt->bind_param("i",$id); return $stmt->execute(); }
}
?>