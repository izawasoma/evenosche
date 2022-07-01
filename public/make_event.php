<?php

namespace LocalMyStudy\Evenosche\exec;

session_start();

require_once ("../vendor/autoload.php");
require_once ("../function/validation.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalMyStudy\Evenosche\Classes\entity\Event;
use LocalMyStudy\Evenosche\Classes\entity\Candidate;
use LocalMyStudy\Evenosche\Classes\entity\CandidateTime;

$candidateParents = "";
$assign = [];
$templatePath = "make_event.html";

if (isset($_POST["btn"])) {
    //未入力チェック
    $addEName = $_POST["addEName"];
    $addEPlace = $_POST["addEPlace"];
    $addEAbout = $_POST["addEAbout"];
    $addEDeadline = $_POST["addEDeadline"];
    $addEStartDay = $_POST["addEStartDay"];
    $addEEndDay = $_POST["addEEndDay"];
    $addENomalPrice = $_POST["addENomalPrice"];
    $addEHighPrice = $_POST["addEHighPrice"];

    $addEName = str_replace("　", " ", $addEName);
    $addEAbout = str_replace("　", " ", $addEAbout);
    $addEDeadline = str_replace("　", " ", $addEDeadline);

    if (empty($addEName)) {
        $validationMsgs["eName"] = "イベント名の入力は必須です。";
    }

    if (empty($addEPlace)) {
        $validationMsgs["ePlace"] = "開催地の入力は必須です。";
    }

    if (empty($addEDeadline)) {
        $validationMsgs["eDeadline"] = "イベント名の入力は必須です。";
    } elseif (!is_date($addEDeadline)) {
        $validationMsgs["eDeadline"] = "入力値が正しくありません。";
    }

    if (!is_date($addEStartDay)) {
        $validationMsgs["eScope"] = "入力値が正しくありません。";
    } elseif (!is_date($addEEndDay)) {
        $validationMsgs["eScope"] = "入力値が正しくありません。";
    }

    $keys = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];


    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            foreach ($_POST[$key] as $input_data) {
                if (!is_time($input_data)) {
                    $validationMsgs[$key] = "時刻の入力値が正しくありません。";
                }
            }
        }
    }

    $event = new Event;
    $event->setEName($addEName);
    $event->setEPlace($addEPlace);
    $event->setEDeadline($addEDeadline);
    $event->setEAbout($addEAbout);
    $event->setEStartDay($addEStartDay);
    $event->setEEndDay($addEEndDay);
    $event->setENomalPrice($addENomalPrice);
    $event->setEHighPrice($addEHighPrice);

    //曜日別の時間候補を作成
    $candidatesOnWeek = [];
    foreach ($keys as $key) {
        $candidatesOnWeek[$key] = null;
        if (isset($_POST[$key])) {
            $work = [];
            foreach ($_POST[$key] as $input_data) {
                $candidateTime = new CandidateTime;
                $candidateTime->setCtTime($input_data);
                $work[] = $candidateTime;
            }
            $candidatesOnWeek[$key] = $work;
        }
    }

    $candidates = [];
    for ($i = $addEStartDay; $i <= $addEEndDay; $i = date('Ymd', strtotime($i . '+1 day'))) {
        $week = date('D', strtotime($i));
        if (!is_null($candidatesOnWeek[$week])) {
            $work = [];
            $candidate = new Candidate;
            $candidate->setCDate($i);
            if($week == "Sun" || $week == "Sat"){
                $candidate->setCPrice($event->getEHighPrice());
            }
            else{
                $candidate->setCPrice($event->getENomalPrice());
            }
            $work["candidate"] = $candidate;
            $work["candidate_time"] = $candidatesOnWeek[$week];
            $candidates[] = $work;
        }
    }

    $event_data = [];
    $event_data["info"] = $event;
    $event_data["candidates"] = $candidates;

    if (empty($validationMsgs)) {
        $_SESSION["event_data"] = serialize($event_data);
        $_SESSION["candidatesOnWeek"] = serialize($candidatesOnWeek);
        if($_POST["btn"] == "goDetail"){
            header("Location:./make_event_detail.php");
            exit;
        }
        else{
            header("Location:./make_event_confirm.php");
            exit;
        }
    } else {
        $assign["varidationMsgs"] = $validationMsgs;
        $assign["candidatesOnWeek"] = $candidatesOnWeek;
        $assign["event"] = $event;
        $templatePath = "make_event.html";
    }
}

$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader);
$html = $twig->render($templatePath, $assign);
echo $html;

?>