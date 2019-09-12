<?php

require("init.php");

$url = getURL();
$router = new App\Router\Router($url);

$router->get("/", function(){
    header("Location: login.php");
});

$router->get("/home", function(){
    header("Location: home.php");
});

$router->get("/login", function(){
    header("Location: login.php");
});

$router->get("/logout", function(){
    header("Location: logout.php");
});

$router->run();

?>