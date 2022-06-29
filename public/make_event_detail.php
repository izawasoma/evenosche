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
    /* echo "<pre>";
    var_dump($event_data);
    echo "</pre>"; */
    $_SESSION["event_data"] = serialize($event_data);
    header("Location:./make_event_confirm.php");
    exit;
}

?>

<!-- <?php if(isset($_POST)): ?>
    <pre>
        <?php //var_dump($assign["event_data"]) ?>
    </pre>
<?php endif; ?> -->

<?php

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"] . "/evenosche/templates");
$twig = new Environment($loader);
$html = $twig->render($templatePath, $assign);
echo $html;

?>
