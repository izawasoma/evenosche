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
        $stmt->bindValue(":ct_time", $candidateTime->getCtTime(), PDO::PARAM_STR);
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
}
?>