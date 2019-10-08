<?php

use App\Middleware\CsrfMiddleware;
use App\Page\PageMaker;

# Variables
$title = "Connexion - Forum";
$description = "Page de connexion au forum";

#Csrf
if (!isset($_SESSION))
{
    session_start();
}
$middleware = new CsrfMiddleware($_SESSION, 50);
$input = "<input type=\"hidden\" name=\"{$middleware->getFormKey()}\" value=\"{$middleware->generateToken()}\"/>";

# Fonctions / Requêtes
$pm = new PageMaker();
if ($pm->getUsercookie()->getIsConnect() == true)
{
    header("location: /home");
    exit(0);
}