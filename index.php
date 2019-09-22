<?php

use App\Cookie\UserCookie;
use App\Cookie\PageMaker;
use App\User;

require_once("vendor/autoload.php");
require_once("init.php");

$url = getURL();
$app = new App\Router\Router($url);

$app->get("/", function()
{
    $pm = new PageMaker("Connexion - Forum", "Page de connexion au forum");
    if ($pm->getUsercookie()->getIsConnect() == true)
    {
        header("location: /home");
        exit(0);
    }
    $pm->start();
    require dirname(__DIR__) . "/jlf/views/login.php";
    $pm->end();
});

$app->get("/logout", function()
{
    UserCookie::erase();
    header("Location: /");
});

$app->get("/home", function()
{
    $pm = new PageMaker("Home - Dollars Forum", "Accueil du forum dollars durarara!");
    $pm->start();
    if ($pm->getUsercookie()->getIsConnect() == false)
    {
        echo "<p>Accès non autorisé.. Veuillez-vous connecté</p>";
        echo "<a href='/'>Accueil</a>";
    }
    else
    {
        require dirname(__DIR__) . "/jlf/views/home.php";
    }
    $pm->end();
});

$app->get("/signup", function()
{
    $pm = new PageMaker("Inscription, Inscription - Forum");
    if ($pm->getUsercookie()->getIsConnect() === true)
    {
        header("Location: /home");
        exit(0);
    }
    $pm->start();
    require dirname(__DIR__) . "/jlf/views/signUp.php";
    $pm->end();
});

$app->get("/404", function()
{
    require dirname(__DIR__) . "/jlf/404.php";
});

$app->run();

?>