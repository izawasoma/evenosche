<?php

namespace LocalMyStudy\Evenosche\Classes\dao;

use PDO;
use LocalMyStudy\Evenosche\Classes\Entity\User;

class UserDAO {
    //DB接続オブジェクト
    private $db;
    //コンストラクタ
    public function __construct(PDO $db) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db = $db;
    }

    //会員登録
    public function insert(User $user): int {
        $sqlInsert = "INSERT INTO users (u_login_id,u_pass,u_name,u_salt,u_stretch) VALUES (:u_login_id,:u_pass,:u_name,:u_salt,:u_stretch)";
        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bindValue(":u_login_id", $user->getULoginId(), PDO::PARAM_STR);
        $stmt->bindValue(":u_pass", $user->getUPass(), PDO::PARAM_STR);
        $stmt->bindValue(":u_name", $user->getUName(), PDO::PARAM_STR);
        $stmt->bindValue(":u_salt", $user->getUSalt(), PDO::PARAM_INT);
        $stmt->bindValue(":u_stretch", $user->getUStretch(), PDO::PARAM_STR);
        $result = $stmt->execute();
        if($result) {
            $dpId = $this->db->lastInsertId();
        }
        else {
            $dpId = -1;
        }
        return  $dpId;
    }

    //ログインIDで検索し件数を取得
    public function findByLoginId(string $ULoginId): ?User {
        $sql = "SELECT * FROM users WHERE u_login_id = :u_login_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":u_login_id", $ULoginId, PDO::PARAM_STR);
        $result = $stmt->execute();

        $user = null;
        if($result && $row = $stmt->fetch()){
            $uId = $row["u_id"];
            $uLoginId = $row["u_login_id"];
            $uPass = $row["u_pass"];
            $uName = $row["u_name"];
            $uSalt = $row["u_salt"];
            $uStretch = $row["u_stretch"];

            $user = new User();
            $user->setUId($uId);
            $user->setULoginId($uLoginId);
            $user->setUPass($uPass);
            $user->setUName($uName);
            $user->setUSalt($uSalt);
            $user->setUStretch($uStretch);
        }
        return $user;
    }
}
?>