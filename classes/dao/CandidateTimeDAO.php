<?php

namespace LocalMyStudy\Evenosche\Classes\Dao;

use PDO;
use LocalMyStudy\Evenosche\Classes\Entity\CandidateTime;

class CandidateTimeDAO {
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
    public function insert(CandidateTime $candidateTime,int $c_id): int {
        $sqlInsert = "INSERT INTO candidate_time (c_id,ct_time) VALUES (:c_id,:ct_time)";
        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bindValue(":ct_time", $candidateTime->getCtTime6dig(), PDO::PARAM_STR);
        $stmt->bindValue(":c_id", $c_id, PDO::PARAM_INT);
        $result = $stmt->execute();

        if($result) {
            $dpId = $this->db->lastInsertId();
        }
        else {
            $dpId = -1;
        }
        return  $dpId;
    }

    public function findByPK(int $ct_id) :CandidateTime{
        $sql = "SELECT * FROM candidate_time WHERE ct_id = :ct_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":ct_id",$ct_id,PDO::PARAM_INT);
        $result = $stmt->execute();

        $candidateTime = null;

        if($result && $row = $stmt->fetch()){
            $ctId = $row["ct_id"];
            $cId = $row["c_id"];
            $ctTime = $row["ct_time"];

            $candidateTime = new CandidateTime;
            $candidateTime->setCtId($ctId);
            $candidateTime->setCId($cId);
            $candidateTime->setCtTime($ctTime);
        }

        return $candidateTime;
    }

    public function findByCId(int $cId) :array{
        $sql = "SELECT * FROM candidate_time WHERE c_id = :c_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":c_id",$cId,PDO::PARAM_INT);
        $result = $stmt->execute();

        $candidateTimeList = [];

        while($row = $stmt->fetch()){
            $ctId = $row["ct_id"];
            $cId = $row["c_id"];
            $ctTime = $row["ct_time"];

            $candidateTime = new CandidateTime;
            $candidateTime->setCtId($ctId);
            $candidateTime->setCId($cId);
            $candidateTime->setCtTime($ctTime);
            $candidateTimeList[$ctId] = $candidateTime;
        }

        return $candidateTimeList;
    }
}
?>