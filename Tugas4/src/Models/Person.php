<?php
namespace Models;

use Interfaces\HasIdentity;

abstract class Person implements HasIdentity {
    protected static int $jumlah = 0;
    protected string $nim;
    protected string $nama;
    protected string $role;

    public function __construct(string $nim, string $nama, string $role = "Mahasiswa") {
        $this->nim = $nim;
        $this->nama = $nama;
        $this->role = $role;
        self::$jumlah++;
    }

    public function getNim(): string {
        return $this->nim;
    }

    public function getNama(): string {
        return $this->nama;
    }

    public function getRole(): string {
        return $this->role;
    }

    public static function getJumlah(): int {
        return self::$jumlah;
    }

    abstract public function deskripsi(): string;
}
?>