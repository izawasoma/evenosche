<?php

namespace LocalMyStudy\Evenosche\Classes\dao;

use PDO;
use LocalMyStudy\Evenosche\Classes\Entity\Event;

class EventDAO {
    //DB接続オブジェクト
    private $db;
    //コンストラクタ
    public function __construct(PDO $db) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db = $db;
    }

    //イベント情報登録
    public function insert(Event $event): int {
        $sqlInsert = "INSERT INTO event (e_name,e_about,e_deadline,e_place,e_start_day,e_end_day,e_high_price,e_nomal_price) VALUES (:e_name,:e_about,:e_deadline,:e_place,:e_start_day,:e_end_day,:e_high_price,:e_nomal_price)";
        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bindValue(":e_name", $event->getEName(), PDO::PARAM_STR);
        $stmt->bindValue(":e_about", $event->getEAbout(), PDO::PARAM_STR);
        $stmt->bindValue(":e_deadline", $event->getEDeadline(), PDO::PARAM_STR);
        $stmt->bindValue(":e_place", $event->getEPlace(), PDO::PARAM_STR);
        $stmt->bindValue(":e_start_day", $event->getEStartDay(), PDO::PARAM_STR);
        $stmt->bindValue(":e_end_day", $event->getEEndDay(), PDO::PARAM_STR);
        $stmt->bindValue(":e_high_price", $event->getEHighPrice(), PDO::PARAM_INT);
        $stmt->bindValue(":e_nomal_price", $event->getENomalPrice(), PDO::PARAM_INT);

        $result = $stmt->execute();

        if($result) {
            $dpId = $this->db->lastInsertId();
        }
        else {
            $dpId = -1;
        }
        return  $dpId;
    }

    public function findByPK(int $e_id) :Event{
        $sql = "SELECT * FROM event WHERE e_id = :e_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":e_id",$e_id,PDO::PARAM_INT);
        $result = $stmt->execute();

        $event = null;

        if($result && $row = $stmt->fetch()){
            $eId = $row["e_id"];
            $eName = $row["e_name"];
            $eAbout = $row["e_about"];
            $eDeadline = $row["e_deadline"];
            $ePlace = $row["e_place"];
            $eStartDay = $row["e_start_day"];
            $eEndDay = $row["e_end_day"];
            $eHighPrice = $row["e_high_price"];
            $eNomalPrice = $row["e_nomal_price"];

            $event = new Event;
            $event->setEId($eId);
            $event->setEName($eName);
            $event->setEAbout($eAbout);
            $event->setEDeadline($eDeadline);
            $event->setEPlace($ePlace);
            $event->setEStartDay($eStartDay);
            $event->setEEndDay($eEndDay);
            $event->setEHighPrice($eHighPrice);
            $event->setENomalPrice($eNomalPrice);
        }

        return $event;
    }

    public function findAll() :array{
        $sql = "SELECT * FROM event";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $eventList = [];

        while($row = $stmt->fetch()){
            $eId = $row["e_id"];
            $eName = $row["e_name"];
            $eAbout = $row["e_about"];
            $eDeadline = $row["e_deadline"];
            $ePlace = $row["e_place"];
            $eStartDay = $row["e_start_day"];
            $eEndDay = $row["e_end_day"];
            $eHighPrice = $row["e_high_price"];
            $eNomalPrice = $row["e_nomal_price"];

            $event = new Event;
            $event->setEId($eId);
            $event->setEName($eName);
            $event->setEAbout($eAbout);
            $event->setEDeadline($eDeadline);
            $event->setEPlace($ePlace);
            $event->setEStartDay($eStartDay);
            $event->setEEndDay($eEndDay);
            $event->setEHighPrice($eHighPrice);
            $event->setENomalPrice($eNomalPrice);

            $eventList[$eId] = $event;
        }

        return $eventList;
    }
}
?>