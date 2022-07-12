<?php
namespace LocalMyStudy\Evenosche\exec;

require_once("../vendor/autoload.php");

session_start();

use PDO;
use PDOException;
use LocalMyStudy\Evenosche\Classes\Conf;
use LocalMyStudy\Evenosche\Classes\dao\EventInfoDAO;
use LocalMyStudy\Evenosche\Classes\entity\EventInfo;

try{
    $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
    $eventInfoDAO = new EventInfoDAO($db);
}
catch(PDOException $ex){

}
finally{
    $db = null;
}
?>