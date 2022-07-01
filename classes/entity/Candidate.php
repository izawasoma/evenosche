<?php

namespace LocalMyStudy\Evenosche\Classes\entity;

class Candidate {
    private ?int $cId = null;
    private ?int $eId = null;
    private ?string $cDate = "";
    private ?int $cPrice = null;

    //以下アクセサメソッド
    public function getCId(): ?int {
        return $this->cId;
    }
    public function setCId(int $cId): void {
        $this->cId = $cId;
    }
    public function getEId(): ?int {
        return $this->eId;
    }
    public function setEId(int $eId): void {
        $this->eId = $eId;
    }
    public function getCDate(): ?string {
        return $this->cDate;
    }
    public function setCDate(string $cDate): void {
        $this->cDate = $cDate;
    }
    public function getCPrice(): ?string {
        return $this->cPrice;
    }
    public function setCPrice(int $cPrice): void {
        $this->cPrice = $cPrice;
    }

    public function getCDateByFilter(): ?string{
        $week = date('D', strtotime($this->getCDate()));
        return date("Y年m月d日",strtotime($this->getCDate()))."(".$week.")";
    }
}
?>