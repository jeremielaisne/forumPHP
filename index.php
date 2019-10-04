<?php

use App\Cookie\UserCookie;
use App\Page\PageMaker;

require_once(__DIR__ . "/vendor/autoload.php");
require_once("common.php");

$url = getURL();
$app = new App\Router\Router($url);

##########
# Router #
##########

$app->get("/", function(){
    require __DIR__ . "/controllers/login.php";
    return $pm->render('login.html.twig', ['title' => $title, 'description' => $description]);
});

$app->get("/logout", function(){
    UserCookie::erase();
    header("Location: /");
});

$app->get("/recovery", function(){
    echo "Recuperation mdp";
});

$app->get("/signup", function(){
    require __DIR__ . "/controllers/signup.php";
    return $pm->render('signup.html.twig', ['title' => $title, 'description' => $description, 'avatars' => $avatars]);
});

$app->get("/404", function(){
    $pm = new PageMaker();
    return $pm->render('404.html.twig', []);
});

$app->get("/home", function(){
    require __DIR__ . "/controllers/home.php";
    return $pm->render('home.html.twig', ['title' => $title, 'description' => $description, 'nickname'=> $nickname, 'nbpost' => $nbpost, 'avatar' => $avatar, 'level' => $level, 'is_working' => $is_working, 'lastconnect' => $lastconnect]);
});

$app->run();

?>