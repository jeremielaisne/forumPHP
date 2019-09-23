<?php

use App\Cookie\UserCookie;
use App\Cookie\PageMaker;

require_once(__DIR__ . "/vendor/autoload.php");
require_once("common.php");

$url = getURL();
$app = new App\Router\Router($url);

##########
# Router #
##########

$app->get("/", function(){
    require __DIR__ . "/controllers/login.php";
    $pm->render('login.html.twig', ['title' => $title, 'description' => $description]);
});

$app->get("/logout", function(){
    UserCookie::erase();
    header("Location: /");
});

$app->get("/home", function(){
    require __DIR__ . "/controllers/home.php";
    $pm->render('home.html.twig', ['title' => $title, 'description' => $description, 'cookie' => $cookie, 'firstname'=> $firstname, 'lastname' => $lastname, 'lastconnect' => $lastconnect]);
});

$app->get("/signup", function(){
    require __DIR__ . "/controllers/signup.php";
    $pm->render('signup.html.twig', ['title' => $title, 'description' => $description]);
});

$app->get("/404", function(){
    $pm = new PageMaker();
    $pm->render('404.html.twig', []);
});

$app->run();

?>