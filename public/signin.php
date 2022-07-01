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

$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader);

$templatePath = "signin.html";
$assign = [];


if(isset($_POST["btn"]) && $_POST["btn"] == "back"){
    header("Location:./signup.php");
    exit;
}

try{
    $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
    $userDAO = new UserDAO($db);
    if(isset($_POST["btn"]) && $_POST["btn"] == "submit"){
        //登録ボタンを押した時ではない
        //バリデーションチェック
        $signInULoginId = $_POST["signInULoginId"];
        $signInUPass = $_POST["signInUPass"];
        $signInULoginId = str_replace("　"," ",$signInULoginId);
        $signInUPass = str_replace("　"," ",$signInUPass);
    
        $validationMsgs = [];
    
        if(empty($signInULoginId)){
            $validationMsgs["error"] = "ログインIDの入力は必須です。";
        }
        if(empty($signInUPass)){
            $validationMsgs["error"] = "パスワードの入力は必須です。";
        }
    
        //ユーザーIDの存在チェック
        $user = $userDAO->findByLoginId($signInULoginId);
        if(empty($user)){
            $validationMsgs["error"] = "ログインID又はパスワードが間違っています";
        }

        if(empty($validationMsgs)){
            //パスワードチェック
            $uPass = $signInUPass;
            for($i=0; $i<$user->getUStretch(); $i++){
                $uPass = md5($user->getUSalt().$uPass);
            }
            if($uPass !== $user->getUnHashedPass()){
                $validationMsgs["error"] = "ログインID又はパスワードが間違っています";
            }
        }
        
        if(empty($validationMsgs)){
            //バリデーションが空
            $_SESSION["userId"] = $user->getUId();
            header("Location:./show_event_list.php");
            exit;
        }
        else{
            //バリデーションが空じゃない
            $assign["validationMsgs"] = $validationMsgs;
            $assign["loginId"] = $signInULoginId;
            $assign["pass"] = $signInUPass;
        }
    }
}
catch(PDOException $ex){
    var_dump($ex);
    echo "error";
    /* $assign["errorMsg"] = "DB接続に失敗しました";
    $templatePath = "error.html"; */
}
finally{
    $db = null;
}

$html = $twig->render($templatePath,$assign);
echo $html;

?>