<?php

use App\Cookie\PageMaker;

# Variables
$title = "Home - Dollars Forum";
$description = "Accueil du forum dollars durarara!";

# Fonctions / Requêtes
$pm = new PageMaker();
if ($pm->getUsercookie()->getIsConnect() == false)
{
    echo "<p>Accès non autorisé.. Veuillez-vous connecté</p>";
    echo "<a href='/'>Accueil</a>";
    exit(0);
}
else
{
    $cookie = $_COOKIE['testForumCookie'];
    $firstname = $pm->getUsercookie()->getUser()->getFirstname();
    $lastname = $pm->getUsercookie()->getUser()->getLastname();
    $lastconnect = $pm->getUsercookie()->getUser()->getUpdatedAt();
}