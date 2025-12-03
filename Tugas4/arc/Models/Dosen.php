<?php
namespace Models;
use Interfaces\HasContact;
use Traits\CanTeach;

class Dosen extends Person implements HasContact {
    use CanTeach;
    private string $nidn;
    private string $keahlian;

    public function __construct(string $id, string $nama, string $nidn, string $keahlian) {
        parent::__construct($id, $nama, "Dosen");
        $this->nidn = $nidn;
        $this->keahlian = $keahlian;
    }

    public function getRole(): string {
        return 'Dosen';
    }

    public function deskripsi(): string {
        return $this->nidn . ' - ' . $this->getNama() . ' (Dosen: ' . $this->keahlian . ')';
    }

    public function getEmail(): string {
        $email = strtolower(str_replace(' ', '.', $this->getNama())) . '@kampus.ac.id';
        return $email;
    }

    public function introduce(): string {
        return "Halo, saya " . $this->getNama();
    }
}
