<?php

namespace LocalMyStudy\Evenosche\exec;

session_start();

if(!isset($_SESSION["userId"])){
    header("Location:./signin.php");
    exit;
}

require_once ("../vendor/autoload.php");
require_once ("../function/validation.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalMyStudy\Evenosche\Classes\entity\Event;
use LocalMyStudy\Evenosche\Classes\entity\Candidate;
use LocalMyStudy\Evenosche\Classes\entity\CandidateTime;
use LocalMyStudy\Evenosche\Classes\dao\EventDAO;
use LocalMyStudy\Evenosche\Classes\dao\CandidateDAO;
use LocalMyStudy\Evenosche\Classes\dao\CandidateTimeDAO;
use PDO;
use PDOException;
use LocalMyStudy\Evenosche\Classes\Conf;

$assign = [];
$templatePath = "make_event_confirm.html";
$entry = false;

if(isset($_SESSION["event_data"])){
    $event_data = unserialize($_SESSION["event_data"]);
    $assign["event_data"] = $event_data;
}

if(isset($_POST["btn"]) && $_POST["btn"] == "submit"){
    $event_data = unserialize($_SESSION["event_data"]);
    try{
        $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
        $eventDAO = new EventDAO($db);
        $candidateDAO = new CandidateDAO($db);
        $candidateTimeDAO = new CandidateTimeDAO($db);
        $eId = $eventDAO->insert($event_data["info"]);
        foreach($event_data["candidates"] as $value){
            $cId = $candidateDAO->insert($value["candidate"],$eId);
            foreach($value["candidate_time"] as $candidateTime){
                $candidateTimeDAO->insert($candidateTime,$cId);
            }
        }
        $entry = true;
    }
    catch(PDOException $ex){

    }
    finally{
        $db = null;
    }
    if($entry){
        header("Location:./make_event_complete.php");
        exit;
    }
}
elseif(isset($_POST["btn"]) && $_POST["btn"] == "back"){

}



$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader);
$html = $twig->render($templatePath, $assign);
echo $html;

?>
