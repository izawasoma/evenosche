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

$assign = [];
$templatePath = "make_event_detail.html";

if(isset($_SESSION["event_data"])){
    $event_data = unserialize($_SESSION["event_data"]);
    $assign["event_data"] = $event_data;
}
if(isset($_POST["btn"])){    
    $work = [];
    foreach($_POST["candidates"] as $key => $value){
        $work = [];
        $work["candidate"] = new Candidate;
        $work["candidate"]->setCDate($key);
        $work["candidate"]->setCPrice($value["price"]);
        foreach($value["time"] as $key => $time){
            $work["candidate_time"][] = new CandidateTime;
            $work["candidate_time"][$key]->setCtTime($time);
        }
        $candidates[] = $work;
    }
    $event_data["candidates"] = $candidates;
    $_SESSION["event_data"] = serialize($event_data);
    header("Location:./make_event_confirm.php");
    exit;
}

$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader);
$html = $twig->render($templatePath, $assign);
echo $html;

?>
