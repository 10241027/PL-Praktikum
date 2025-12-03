<?php
namespace Models;

use Traits\CanIntroduce;
use Interfaces\HasContact;

class Mahasiswa extends Person implements HasContact {
    use CanIntroduce;
    private string $jurusan;

    public function __construct(string $nim, string $nama, string $jurusan) {
        parent::__construct($nim, $nama, "Mahasiswa");
        $this->jurusan = $jurusan;
    }

    public function deskripsi(): string {
        return $this->nim . " - " . $this->nama . " (" . $this->jurusan . ")";
    }

    public function getEmail(): string {
        $email = strtolower(str_replace(' ', '.', $this->nama)) . '@kampus.ac.id';
        return $email;
    }
}