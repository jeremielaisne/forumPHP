<?php

use App\Cookie\PageMaker;

# Variables
$title = "Inscription";
$description = "Inscription - Forum";

#Fonctions
$pm = new PageMaker();
if ($pm->getUsercookie()->getIsConnect() === true)
{
    header("Location: /home");
    exit(0);
}