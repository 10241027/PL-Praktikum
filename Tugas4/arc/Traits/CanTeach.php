<?php
namespace Traits;
trait CanTeach {
    public function teach($mataKuliah): string {
        return $this->getNama() . " mengajar " . $mataKuliah;
    }
}
