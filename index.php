<?php

require("init.php");

$url = getURL();
$router = new App\Router\Router($url);

$router->get("/", function(){
    header("Location: views/login.php");
});

$router->get("/home", function(){
    header("Location: views/home.php");
});

$router->run();

?>