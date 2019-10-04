<?php

use App\Page\PageMaker;

# Variables
$title = "Inscription";
$description = "Inscription - Forum";
$avatars = ['ASUNA','BROOKE','CELTY','CHITOGE','CLEAR','EDWARD','EZRA','HARUHI','HATSUNE','HINATA','ICHIGO','KAKASHI','KIRITO','KISUKE','LIGHT','LUFFY','NARUTO','NATSU','OREKI','RIKKA','LEE','SASUKE','SHIZUO','USOPP'];

#Fonctions
$pm = new PageMaker();
if ($pm->getUsercookie()->getIsConnect() === true)
{
    header("location: /home");
    exit(0);
}