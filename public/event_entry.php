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
use LocalMyStudy\Evenosche\Classes\entity\Hope;
use LocalMyStudy\Evenosche\Classes\dao\EventDAO;
use LocalMyStudy\Evenosche\Classes\dao\CandidateDAO;
use LocalMyStudy\Evenosche\Classes\dao\CandidateTimeDAO;
use LocalMyStudy\Evenosche\Classes\dao\HopeDAO;
use PDO;
use PDOException;
use LocalMyStudy\Evenosche\Classes\Conf;

$assign = [];
$templatePath = "event_entry.html";

$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader);

$eId = $_GET["eId"];
if (isset($_POST["entry"])) {
    $uId = $_SESSION["userId"];
    $hDate = date("YmdHis");
    $errorFlg = 0;
    try {
        $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
        $hopeDAO = new HopeDAO($db);
        foreach ($_POST["entry"] as $ctId) {
            $hope = new Hope;
            $hope->setUId($uId);
            $hope->setHDate($hDate);
            $hope->setCtId($ctId);
            $hopeDAO->insert($hope);
            if ($hopeDAO < 0) {
                $errorFlg = 1;
            }
        }
    } catch (PDOException $ex) {
    } finally {
        $db = null;
    }
    if ($errorFlg == 0) {
        header("Location:./show_event_list.php");
        exit;
    }
} else {
    try {
        $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
        $eventDAO = new EventDAO($db);
        $candidateDAO = new CandidateDAO($db);
        $candidateTimeDAO = new CandidateTimeDAO($db);
        $hopeDAO = new HopeDAO($db);
        $event = [];
        $event["info"] = $eventDAO->findByPK($eId);
        $candidateList = $candidateDAO->findByEid($eId);
        $event["candidates"] = [];
        $i = 0;
        foreach ($candidateList as $candidate) {
            $event["candidates"][$i]["candidate"] = $candidate;
            $candidateTimeList = $candidateTimeDAO->findByCId($candidate->getCId());
            $j = 0;
            foreach ($candidateTimeList as $candidateTime) {
                $event["candidates"][$i]["candidate_time"][$j]["info"] = $candidateTime;
                $event["candidates"][$i]["candidate_time"][$j]["count"] = $hopeDAO->countByCtId($candidateTime->getCtId());
                $j++;
            }
            $i++;
        }
        $assign["event"] = $event;
    } catch (PDOException $ex) {
    } finally {
        $db = null;
    }
}

$html = $twig->render($templatePath, $assign);
echo $html;
