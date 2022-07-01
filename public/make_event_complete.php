<?php

namespace LocalMyStudy\Evenosche\exec;

session_start();

require_once ("../vendor/autoload.php");
require_once ("../function/validation.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$assign = [];
$templatePath = "make_event_complete.html";

$loader = new FilesystemLoader("../templates");
$twig = new Environment($loader);

$html = $twig->render($templatePath);
echo $html;

?>
