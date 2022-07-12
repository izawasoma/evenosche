<?php

namespace LocalMyStudy\Evenosche\Classes\dao;

use PDO;
use LocalMyStudy\Evenosche\Classes\entity\EventInfo;

class EventInfoDAO {
    //DB接続オブジェクト
    private $db;
    //コンストラクタ
    public function __construct(PDO $db) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db = $db;
    }

    public function findByEId(int $eId) :EventInfo{
        $sql = "SELECT * FROM event_info WHERE e_id = :e_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":e_id",$eId,PDO::PARAM_INT);
        $result = $stmt->execute();

        $eventInfo = "";

        $eId = -1;
        $cId = -1;
        $ctId = -1;
        $uId = -1;
        $count = 0;

        $candidateInfo = [];


        while($row = $stmt->fetch()){
            if($eId != $row["e_id"]){
                $eId = $row["e_id"];
                
                $eName = $row["e_name"];
                $eAbout = $row["e_about"];
                $ePlace = $row["e_place"];
                $eDeadline = $row["e_deadline"];
                $eStartDay = $row["e_start_day"];
                $eEndDay = $row["e_end_day"];
                $eHighPrice = $row["e_high_price"];
                $eNomalPrice = $row["e_nomal_price"];
    
                $eventInfo = new EventInfo;
                $eventInfo->setEId($eId);
                $eventInfo->setEName($eName);
                $eventInfo->setEPlace($ePlace);
                $eventInfo->setEAbout($eAbout);
                $eventInfo->setEDeadline($eDeadline);
                $eventInfo->setEStartDay($eStartDay);
                $eventInfo->setEEndDay($eEndDay);
                $eventInfo->setEHighPrice($eHighPrice);
                $eventInfo->setENomalPrice($eNomalPrice);
            }
            if($cId != $row["c_id"]){
                $cId = $row["c_id"];
                $candidateInfo[$cId]["candidateDate"]["cId"] = $cId;
                $candidateInfo[$cId]["candidateDate"]["cPrice"] = $row["c_price"];
                $candidateInfo[$cId]["candidateDate"]["cDate"] = $row["c_date"];
                $candidateInfo[$cId]["candidateDate"]["cDateEdited"] = Date("Y年m月d日",strtotime($row["c_date"]));
                $ctId = -1;
            }
            if($ctId != $row["ct_id"]){
                $ctId = $row["ct_id"];
                $candidateInfo[$cId]["candidateTime"][$ctId]["ctId"] = $ctId;
                $candidateInfo[$cId]["candidateTime"][$ctId]["ctTime"] = $row["ct_time"];
                $candidateInfo[$cId]["candidateTime"][$ctId]["ctTimeEdited"] = $this->getCTTimeByFilter($row["ct_time"]);
                $uId = -1;
                $count = 0;
            }
            if($uId != $row["u_id"] && !is_null($row["u_id"])){
                $uId = $row["u_id"];
                $candidateInfo[$cId]["candidateTime"][$ctId]["member"][$uId] = $row["u_name"];
                $count++;
            }
            $candidateInfo[$cId]["candidateTime"][$ctId]["count"] = $count;
        }
        if(!empty($candidateInfo)){
            $eventInfo->setCandidateInfo($candidateInfo);
        }
        return $eventInfo;
    }

    public function getCtTimeByFilter($time): ?string{
        if(strlen($time) == 4){
            $hour = substr($time,0,2);
            $min = substr($time,2,2);
            return $hour . ":" . $min;
        }
        else{
            return substr($time,0,5);
        }
    }
}

?>