<?php 
namespace LocalMyStudy\Evenosche\exec;

session_start();

require_once ($_SERVER["DOCUMENT_ROOT"]) . "/evenosche/vendor/autoload.php";
require_once ($_SERVER["DOCUMENT_ROOT"]) . "/evenosche/function/validation.php";

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use PDO;
use PDOException;
use LocalMyStudy\Evenosche\Classes\Conf;

use LocalMyStudy\Evenosche\Classes\Entity\Hope;
use LocalMyStudy\Evenosche\Classes\Dao\EventDAO;
use LocalMyStudy\Evenosche\Classes\Dao\CandidateDAO;
use LocalMyStudy\Evenosche\Classes\Dao\CandidateTimeDAO;
use LocalMyStudy\Evenosche\Classes\Dao\HopeDAO;

$assign = [];
$templatePath = "show_event_list_detail.html";

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"] . "/evenosche/templates");
$twig = new Environment($loader);

$eId  = $_GET["eId"];

try{
    $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
    $eventDAO = new EventDAO($db);
    $candidateDAO = new CandidateDAO($db);
    $candidateTimeDAO = new CandidateTimeDAO($db);
    $hopeDAO = new HopeDAO($db);
    $event = [];
    $event["info"] = $eventDAO->findByPK($eId);
    $candidateList = $candidateDAO->findByEid($eId);
    $event["candidates"] = [];
    $i = 0;
    foreach($candidateList as $candidate){
        $event["candidates"][$i]["candidate"] = $candidate;
        $candidateTimeList = $candidateTimeDAO->findByCId($candidate->getCId());
        $j = 0;
        foreach($candidateTimeList as $candidateTime){
            $event["candidates"][$i]["candidate_time"][$j]["info"] = $candidateTime;
            $event["candidates"][$i]["candidate_time"][$j]["count"] = $hopeDAO->countByCtId($candidateTime->getCtId());
            $j++;
        }
        $i++;
    }
    $assign["event"] = $event;
}
catch(PDOException $ex){

}
finally{
    $db = null;
}

$html = $twig->render($templatePath,$assign);
echo $html;

?>