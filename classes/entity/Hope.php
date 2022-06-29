<?php

namespace LocalMyStudy\Evenosche\Classes\Entity;

class Hope {
    private ?int $uId = null;
    private ?int $ctId = null;
    private ?string $hDate = "";
    private ?int $hCount = null;

    //以下アクセサメソッド
    public function getUId(): ?int {
        return $this->uId;
    }
    public function setUId(int $uId): void {
        $this->uId = $uId;
    }
    public function getCtId(): ?int {
        return $this->ctId;
    }
    public function setCtId(int $ctId): void {
        $this->ctId = $ctId;
    }
    public function getHDate(): ?string {
        return $this->hDate;
    }
    public function setHDate(string $hDate): void {
        $this->hDate = $hDate;
    }
    public function getHCount(): ?int {
        return $this->hCount;
    }
    public function setHCount(string $hCount): void {
        $this->hCount = $hCount;
    }
}

?>