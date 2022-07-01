<?php

namespace LocalMyStudy\Evenosche\exec;

require_once("../vendor/autoload.php");

session_start();

use PDO;
use PDOException;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalMyStudy\Evenosche\Classes\Conf;
use LocalMyStudy\Evenosche\Classes\dao\UserDAO;
use LocalMyStudy\Evenosche\Classes\entity\User;


$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader);

$templatePath = "signup_confirm.html";


if(isset($_POST["btn"]) && $_POST["btn"] == "back"){
    header("Location:./signup.php");
    exit;
}

try{
    $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
    $userDAO = new UserDAO($db);
    if(isset($_POST["btn"]) && $_POST["btn"] == "submit"){
        //登録ボタンを押した時
        $user = unserialize($_SESSION["user"]);
        $userId = $userDAO->insert($user);
        if($userId === -1){
            $assign["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
            $templatePath = "error.html";
        }
        else{
            header("Location:./signup_complete.php?username=".$user->getUName());
            exit;
        }
    }
    else{
        //登録ボタンを押した時ではない
        //バリデーションチェック
        $signInULoginId = $_POST["signInULoginId"];
        $signInUPass = $_POST["signInUPass"];
        $signInUName = $_POST["signInUName"];
        $signInULoginId = str_replace("　"," ",$signInULoginId);
        $signInUPass = str_replace("　"," ",$signInUPass);
        $signInUName = str_replace("　"," ",$signInUName);

        $validationMsgs = [];

        if(empty($signInULoginId)){
            $validationMsgs["uLoginId"] = "ログインIDの入力は必須です。";
        }
        if(empty($signInUPass)){
            $validationMsgs["uPass"] = "パスワードの入力は必須です。";
        }
        if(empty($signInUName)){
            $validationMsgs["uName"] = "表示名の入力は必須です。";
        }

        $user = new User();
        $user->setULoginId($signInULoginId);
        $user->setUPass($signInUPass);
        $user->setUName($signInUName);

        //ユーザーIDの重複をチェック
        $userDB = $userDAO->findByLoginId($user->getULoginId());
        if(!empty($userDB)){
            $validationMsgs["uLoginId"] = "そのログインIDは既に使用されています。別のIDを入力してください。";
        }
        if(empty($validationMsgs)){
            //バリデーションが空
            $assign["user"] = $user;
            $_SESSION["user"] = serialize($user);
        }
        else{
            //バリデーションが空じゃない
            $assign["validationMsgs"] = $validationMsgs;
            $assign["user"] = $user;
            $templatePath = "signup.html";
        }
    }
}
catch(PDOException $ex){
    var_dump($ex);
    $assign["errorMsg"] = "DB接続に失敗しました";
    $templatePath = "error.html";
}
finally{
    $db = null;
}

$html = $twig->render($templatePath,$assign);
echo $html;

?>