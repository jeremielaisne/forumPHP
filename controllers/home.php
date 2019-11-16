<?php

use App\Group;
use App\Forum;
use App\User;
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
    $level = $pm->getUsercookie()->getUser()->getLvl();
    $is_working = $pm->getUsercookie()->getUser()->getIsWorking();

    $nbGroups = Group::getNbGroups();
    $list_last_message = [];
    $tab_forums = [];
    for ($i=1; $i<=$nbGroups; $i++)
    {
        $forums = Forum::getAll(true, $i);
        foreach ($forums as $forum)
        {
            $id_forum = $forum->getId();
            $last_message = Forum::getLastMessage($id_forum, true);
            $list_last_message[$id_forum] = $last_message;
        }
        $tab_forums[$i] = $forums;
    }
    $user = $pm->getUsercookie()->getUser();
    $user->update();
    $users_connected = User::getAllConnected();
}