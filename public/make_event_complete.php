<?php

namespace LocalMyStudy\Evenosche\exec;

session_start();

require_once ($_SERVER["DOCUMENT_ROOT"]) . "/evenosche/vendor/autoload.php";
require_once ($_SERVER["DOCUMENT_ROOT"]) . "/evenosche/function/validation.php";

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$assign = [];
$templatePath = "make_event_complete.html";

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"] . "/evenosche/templates");
$twig = new Environment($loader);

$html = $twig->render($templatePath);
echo $html;

?>
