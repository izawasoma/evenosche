<?php

namespace LocalMyStudy\Evenosche\Classes\entity;

class User {
    private ?int $uId = null;
    private ?string $uLoginId = "";
    private ?string $uPass = "";
    private ?string $uName = "";
    private ?string $uSalt = "";
    private ?int $uStretch = null;

    private ?string $unHashedPass = "";

    //以下アクセサメソッド
    public function getUId(): ?int {
        return $this->uId;
    }
    public function setUId(int $uId): void {
        $this->uId = $uId;
    }
    public function getULoginId(): ?string {
        return $this->uLoginId;
    }
    public function setULoginId(string $uLoginId): void {
        $this->uLoginId = $uLoginId;
    }
    public function getUPass(): ?string {
        return $this->uPass;
    }
    public function getUnHashedPass(): ?string {
        return $this->unHashedPass;
    }
    public function setUPass(string $uPass): void {
        //ハッシュ化していないパスワード
        $this->unHashedPass = $uPass;
        //ソルト生成
        $this->uSalt = uniqid();
        //ストレッチ
        $this->uStretch = mt_rand(10000,100000);
        //パスワードハッシュ化
        for($i=0; $i<$this->uStretch; $i++){
            $uPass = md5($this->uSalt.$uPass);
        }
        $this->uPass = $uPass;
    }
    public function getUName(): ?string {
        return $this->uName;
    }
    public function setUName(string $uName): void {
        $this->uName = $uName;
    }
    public function getUSalt(): ?string {
        return $this->uSalt;
    }
    public function setUSalt(string $uSalt): void {
        $this->uSalt = $uSalt;
    }
    public function getUStretch(): ?string {
        return $this->uStretch;
    }
    public function setUStretch(string $uStretch): void {
        $this->uStretch = $uStretch;
    }
}
?>