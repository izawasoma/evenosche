<?php
namespace LocalMyStudy\Evenosche\Classes\entity;

class EventInfo{
    private ?int $eId = null;
    private ?string $eName = "";
    private ?string $eAbout = "";
    private ?string $eDeadline = "";
    private ?string $ePlace = "";
    private ?string $eStartDay = "";
    private ?string $eEndDay = "";
    private ?int $eHighPrice = null;
    private ?int $eNomalPrice = null;
    private ?array $candidateInfo = [];

    public function getEId(): ?int {
        return $this->eId;
    }
    public function setEId(int $eId): void {
        $this->eId = $eId;
    }
    public function getEName(): ?string {
        return $this->eName;
    }
    public function setEName(string $eName): void {
        $this->eName = $eName;
    }
    public function getEAbout(): ?string {
        return $this->eAbout;
    }
    public function setEAbout(string $eAbout): void {
        $this->eAbout = $eAbout;
    }
    public function getEDeadline(): ?string {
        return $this->eDeadline;
    }
    public function setEDeadline(string $eDeadline): void {
        $this->eDeadline = $eDeadline;
    }
    public function getEPlace(): ?string {
        return $this->ePlace;
    }
    public function setEPlace(string $ePlace): void {
        $this->ePlace = $ePlace;
    }
    public function getEStartDay(): ?string {
        return $this->eStartDay;
    }
    public function setEStartDay(string $eStartDay): void {
        $this->eStartDay = $eStartDay;
    }
    public function getEEndDay(): ?string {
        return $this->eEndDay;
    }
    public function setEEndDay(string $eEndDay): void {
        $this->eEndDay = $eEndDay;
    }
    public function getEHighPrice(): ?int {
        return $this->eHighPrice;
    }
    public function setEHighPrice(int $eHighPrice): void {
        $this->eHighPrice = $eHighPrice;
    }
    public function getENomalPrice(): ?int {
        return $this->eNomalPrice;
    }
    public function setENomalPrice(int $eNomalPrice): void {
        $this->eNomalPrice = $eNomalPrice;
    }
    public function getCandidateInfo(): ?array {
        return $this->candidateInfo;
    }
    public function setCandidateInfo(array $candidateInfo): void {
        $this->candidateInfo = $candidateInfo;
    }
    public function getEDeadlineByFilter(): ?string{
        return Date("Y???m???d???",strtotime($this->eDeadline));
    }
    public function getEStartDayByFilter(): ?string{
        return Date("Y???m???d???",strtotime($this->eStartDay));
    }
    public function getEEndDayByFilter(): ?string{
        return Date("Y???m???d???",strtotime($this->eEndDay));
    }
}
?>