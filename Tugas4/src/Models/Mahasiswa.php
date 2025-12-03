<?php
namespace Models;

use Traits\CanIntroduce;

class Mahasiswa extends Person {
    use CanIntroduce;

    private string $jurusan;

    public function __construct(string $nim, string $nama, string $jurusan) {
        parent::__construct($nim, $nama, "Mahasiswa");
        $this->jurusan = $jurusan;
    }

    public function deskripsi(): string {
        return $this->nim . " - " . $this->nama . " (" . $this->jurusan . ")";
    }
}
?>