<?php

namespace LocalMyStudy\Evenosche\Classes\dao;

use PDO;
use LocalMyStudy\Evenosche\Classes\Entity\Hope;

class HopeDAO {
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
    public function insert(hope $hope): int {
        $sqlInsert = "INSERT INTO hope (u_id,ct_id,h_date) VALUES (:u_id,:ct_id,:h_date)";
        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bindValue(":u_id", $hope->getUId(), PDO::PARAM_INT);
        $stmt->bindValue(":ct_id", $hope->getCtId(), PDO::PARAM_INT);
        $stmt->bindValue(":h_date", $hope->getHDate(), PDO::PARAM_STR);

        $result = $stmt->execute();

        if($result) {
            $hpId = $this->db->lastInsertId();
        }
        else {
            $hpId = -1;
        }
        return  $hpId;
    }

    public function countByCtId(int $ctId): Hope {
        $sql = "SELECT COUNT(*) AS count from hope where ct_id = :ct_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":ct_id", $ctId, PDO::PARAM_INT);

        $result = $stmt->execute();

        if($result && $row = $stmt->fetch()){
            $count = $row["count"];
            $hope = new Hope;
            $hope->setHCount($count);
        }

        return  $hope;
    }
}
?>