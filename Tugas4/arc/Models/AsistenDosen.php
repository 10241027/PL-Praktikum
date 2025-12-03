<?php
namespace Models;
use Interfaces\HasContact;

interface CanAssist {
    public function getAssistantRole(): string;
}

class AsistenDosen extends Mahasiswa implements CanAssist, HasContact {
    private string $bidang;

    public function __construct(string $nim, string $nama, string $jurusan, string $bidang) {
        parent::__construct($nim, $nama, $jurusan);
        $this->bidang = $bidang;
    }

    public function getRole(): string {
        return "Asisten Dosen";
    }

    public function getAssistantRole(): string {
        return "Asisten Dosen di bidang " . $this->bidang;
    }

    public function getEmail(): string {
        $email = strtolower(str_replace(' ', '.', $this->getNama())) . '@kampus.ac.id';
        return $email;
    }

    public function deskripsi(): string {
        return $this->getNim() . ' - ' . $this->getNama() . ' (Asisten Dosen: ' . $this->bidang . ')';
    }
}