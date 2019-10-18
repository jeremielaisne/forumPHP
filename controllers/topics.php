<?php

use App\Topic;
use App\Middleware\CsrfMiddleware;
use App\Page\PageMaker;

# Variables
//TODO $nb_page_forum & $nb_page_topic
$nb_page_forum = substr(strrchr($page_forum, "/"), 1);
$nb_page_topic = substr(strrchr($page_topic, "/"), 1);

$search = (string) getFormVal("search");

$topic = new Topic($id_topic);
if ($topic->isExist())
{
    echo "TODO";
}
else
{
    header("Location: /404.php");
    exit(0);
}