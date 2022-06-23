<?php

namespace LocalMyStudy\Evenosche\exec;
session_start();

require_once($_SERVER["DOCUMENT_ROOT"])."/evenosche/vendor/autoload.php";

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/evenosche/templates");
$twig = new Environment($loader);
$assign = [];

if(isset($_SESSION["user"])){
    $assign["user"] = unserialize($_SESSION["user"]);
    unset($_SESSION["user"]);
}

$html = $twig->render("signup.html",$assign);
echo $html;

?>