<?php 
namespace LocalMyStudy\Evenosche\exec;

session_start();

require_once ("../vendor/autoload.php");
require_once ("../function/validation.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalMyStudy\Evenosche\Classes\dao\EventDAO;
use PDO;
use PDOException;
use LocalMyStudy\Evenosche\Classes\Conf;

$assign = [];
$templatePath = "show_event_list.html";

$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader);

try{
    $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
    $eventDAO = new EventDAO($db);
    $assign["eventList"] = $eventDAO->findAll();
}
catch(PDOException $ex){

}
finally{
    $db = null;
}

$html = $twig->render($templatePath,$assign);
echo $html;

?>