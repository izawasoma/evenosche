<?php 
namespace LocalMyStudy\Evenosche\exec;

session_start();

require_once ($_SERVER["DOCUMENT_ROOT"]) . "/evenosche/vendor/autoload.php";
require_once ($_SERVER["DOCUMENT_ROOT"]) . "/evenosche/function/validation.php";

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalMyStudy\Evenosche\Classes\Entity\Event;
use LocalMyStudy\Evenosche\Classes\Entity\Candidate;
use LocalMyStudy\Evenosche\Classes\Entity\CandidateTime;
use LocalMyStudy\Evenosche\Classes\Dao\EventDAO;
use LocalMyStudy\Evenosche\Classes\Dao\CandidateDAO;
use LocalMyStudy\Evenosche\Classes\Dao\CandidateTimeDAO;
use PDO;
use PDOException;
use LocalMyStudy\Evenosche\Classes\Conf;

if(isset($_POST["entry"])){

}
else{
    try{
        $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
        $eventDAO = new EventDAO($db);
        $candidateDAO = new CandidateDAO($db);
        $candidateTimeDAO = new CandidateTimeDAO($db);
    }
    catch(PDOException $ex){

    }
    finally{
        $db = null;
    }
}
?>