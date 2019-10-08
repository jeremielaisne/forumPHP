<?php

use App\Middleware\CsrfMiddleware;
use App\Page\PageMaker;

# Variables
$title = "Inscription";
$description = "Inscription - Forum";
$avatars = ['ASUNA','BROOKE','CELTY','CHITOGE','CLEAR','EDWARD','EZRA','HARUHI','HATSUNE','HINATA','ICHIGO','KAKASHI','KIRITO','KISUKE','LIGHT','LUFFY','NARUTO','NATSU','OREKI','RIKKA','LEE','SASUKE','SHIZUO','USOPP'];

#Csrf
if (!isset($_SESSION))
{
    session_start();
}
$middleware = new CsrfMiddleware($_SESSION, 50);
$input = "<input type=\"hidden\" name=\"{$middleware->getFormKey()}\" value=\"{$middleware->generateToken()}\"/>";

#Fonctions
$pm = new PageMaker();
if ($pm->getUsercookie()->getIsConnect() === true)
{
    header("location: /home");
    exit(0);
}