<?php

namespace LocalMyStudy\Evenosche\Classes\entity;

class CandidateTime {
    private ?int $ctId = null;
    private ?int $cId = null;
    private ?string $ctTime = "";

    //以下アクセサメソッド
    public function getCtId(): ?int {
        return $this->ctId;
    }
    public function setCtId(int $ctId): void {
        $this->ctId = $ctId;
    }
    public function getCId(): ?int {
        return $this->cId;
    }
    public function setCId(int $cId): void {
        $this->cId = $cId;
    }
    public function getCtTime(): ?string {
        return $this->ctTime;
    }
    public function setCtTime(string $ctTime): void {
        $this->ctTime = $ctTime;
    }
    
    public function getCtTimeByFilter(): ?string{
        if(strlen($this->ctTime) == 4){
            $hour = substr($this->ctTime,0,2);
            $min = substr($this->ctTime,2,2);
            return $hour . ":" . $min;
        }
        else{
            return substr($this->ctTime,0,5);
        }
    }
    public function getCtTime6dig(): ?string{
        return $this->ctTime."00";
    }
}
?>