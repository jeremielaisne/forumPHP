<?php

use App\Forum;
use App\Topic;
use App\Page\PageMaker;

# Variables
$title = "Topic - Dollars Forum";
$description = "Topics dollars durarara!";

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
    $avatar = $pm->getUsercookie()->getUser()->getAvatar();
    $nbpost = $pm->getUsercookie()->getUser()->getNbPost();
    $level = $pm->getUsercookie()->getUser()->getLvl();
    $is_working = $pm->getUsercookie()->getUser()->getIsWorking();

    $forum = new Forum($id);
    if ($forum->isExist())
    {
        $forum->load(true);
        $title = $forum->getName() . " - Dollars Forum";
        $description = $forum->getDescription() . " - Topics dollars durarara!";
        $deb = ($page-1)*PAGINATION_NB;
        $fin = $page*PAGINATION_NB;

        $nbTopics = $forum->getNbTopics();
        $pagination1 = $page;
        $pagination2 = ceil($nbTopics/PAGINATION_NB);

        $topics = Forum::getTopics($forum->getId(), true, $deb, $fin);

        $list_last_message = [];
        foreach ($topics as $topic)
        {
            $id_topic = $topic->getId();
            $last_message = Topic::getLastMessage($id_topic, true);
            $list_last_message[$id_topic] = $last_message;
        }
    }
    else
    {
        header("Location: /404.php");
        exit(0);
    }
}