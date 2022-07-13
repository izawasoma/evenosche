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
use PDO;
use PDOException;
use LocalMyStudy\Evenosche\Classes\Conf;

use LocalMyStudy\Evenosche\Classes\dao\EventInfoDAO;

$assign = [];
$templatePath = "show_event_list_detail.html";

$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader);

$eId  = $_GET["eId"];

try{
    $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
    $eventInfoDAO = new EventInfoDAO($db);
    $assign["event"] = $eventInfoDAO->findByEId($eId);
}
catch(PDOException $ex){

}
finally{
    $db = null;
}

$html = $twig->render($templatePath,$assign);
echo $html;

?>