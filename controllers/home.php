<?php

use App\Forum;
use App\Page\PageMaker;

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
    $nickname = $pm->getUsercookie()->getUser()->getNickname();
    $nbpost = $pm->getUsercookie()->getUser()->getNbPost();
    $avatar = $pm->getUsercookie()->getUser()->getAvatar();
    $level = $pm->getUsercookie()->getUser()->getLvl();
    $is_working = $pm->getUsercookie()->getUser()->getIsWorking();

    $forums = Forum::getAll();
}