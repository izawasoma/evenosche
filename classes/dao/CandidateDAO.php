<?php

namespace LocalMyStudy\Evenosche\Classes\dao;

use PDO;
use LocalMyStudy\Evenosche\Classes\entity\Candidate;

class CandidateDAO {
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
    public function insert(Candidate $candidate,int $e_id): int {
        $sqlInsert = "INSERT INTO candidate (e_id,c_date,c_price) VALUES (:e_id,:c_date,:c_price)";
        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bindValue(":e_id", $e_id, PDO::PARAM_INT);
        $stmt->bindValue(":c_date", $candidate->getCDate(), PDO::PARAM_STR);
        $stmt->bindValue(":c_price", $candidate->getCPrice(), PDO::PARAM_INT);

        $result = $stmt->execute();

        if($result) {
            $dpId = $this->db->lastInsertId();
        }
        else {
            $dpId = -1;
        }
        return  $dpId;
    }

    public function findByPK(int $c_id) :Candidate{
        $sql = "SELECT * FROM candidate WHERE c_id = :c_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":c_id",$c_id,PDO::PARAM_INT);
        $result = $stmt->execute();

        $candidate = null;

        if($result && $row = $stmt->fetch()){
            $cId = $row["c_id"];
            $eId = $row["e_id"];
            $cDate = $row["c_date"];
            $cPrice = $row["c_price"];

            $candidate = new Candidate;
            $candidate->setCId($cId);
            $candidate->setEId($eId);
            $candidate->setCDate($cDate);
            $candidate->setCPrice($cPrice);
        }

        return $candidate;
    }

    public function findByEid(int $EId) :array{
        $sql = "SELECT * FROM candidate WHERE e_id = :e_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":e_id",$EId,PDO::PARAM_INT);
        $result = $stmt->execute();

        $candidateList = [];

        while($row = $stmt->fetch()){
            $cId = $row["c_id"];
            $eId = $row["e_id"];
            $cDate = $row["c_date"];
            $cPrice = $row["c_price"];

            $candidate = new Candidate;
            $candidate->setCId($cId);
            $candidate->setEId($eId);
            $candidate->setCDate($cDate);
            $candidate->setCPrice($cPrice);
            $candidateList[$cId] = $candidate;
        }

        return $candidateList;
    }
}
?>