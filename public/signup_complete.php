<?php

namespace LocalMyStudy\Evenosche\exec;
session_start();

require_once("../vendor/autoload.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/evenosche/templates");
$twig = new Environment($loader);
$assign = [];

if(isset($_GET["username"])){
    $assign["username"] = $_GET["username"];
}
else{
    header("Location:./signup.php");
    exit;
}

$html = $twig->render("signup_complete.html",$assign);
echo $html;

?>