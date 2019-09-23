<?php

use App\Cookie\PageMaker;

# Variables
$title = "Connexion - Forum";
$description = "Page de connexion au forum";

# Fonctions / Requêtes
$pm = new PageMaker();
if ($pm->getUsercookie()->getIsConnect() == true)
{
    header("location: /home");
    exit(0);
}