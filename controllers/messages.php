<?php

use App\Forum;
use App\Topic;
use App\Message;
use App\Page\PageMaker;

# Variables
$title = "Message - Dollars Forum";
$description = "Messages dollars durarara!";

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
    $search = (string) getFormVal("search");
    $nickname = $pm->getUsercookie()->getUser()->getNickname();
    $nbpost = $pm->getUsercookie()->getUser()->getNbPost();
    $level = $pm->getUsercookie()->getUser()->getLvl();
    $is_working = $pm->getUsercookie()->getUser()->getIsWorking();

    $forum = new Forum($id_forum);
    if ($forum->isExist())
    {
        $topic = new Topic($id_topic);
        if ($topic->isExist())
        {
            //$title = $topic->getName() . " - Dollars Forum";
            //$description = $topic->getDescription() . " - Topics dollars durarara!";
            //$messages = Topic::getMessages($id_forum, true);

        }
    }
}