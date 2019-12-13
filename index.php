<?php

use App\Cookie\UserCookie;
use App\Page\PageMaker;

require_once(__DIR__ . "/vendor/autoload.php");
require_once("common.php");

$url = getURL();
$app = new App\Router\Router($url);

##########
# Router #
##########

$app->get("/", function(){
    require __DIR__ . "/controllers/login.php";
    $pm->render('login.html.twig', ['title' => $title, 'description' => $description, '_csrf' => $input]);
});

$app->get("/logout", function(){
    UserCookie::erase();
    header("Location: /");
});

$app->get("/recovery", function(){
    echo "Recuperation mdp";
});

$app->get("/signup", function(){
    require __DIR__ . "/controllers/signup.php";
    $pm->render('signup.html.twig', ['title' => $title, 'description' => $description, 
    'avatars' => $avatars, '_csrf' => $input]);
});

$app->get("/404", function(){
    $pm = new PageMaker();
    $pm->render('404.html.twig', []);
});

$app->get("/home", function(){
    require __DIR__ . "/controllers/home.php";
    $pm->render('home.html.twig', ['title' => $title, 'description' => $description, 
    'nickname'=> $nickname, 'nbpost' => $nbpost, 'level' => $level, 'is_working' => $is_working, 
    'tab_forums' => $tab_forums, 'last_messages' => $list_last_message, 'users' => $users_connected]);
});

$app->get("/forum/:nb/page-:page", function($id, $page) use ($app){
    require __DIR__ . "/controllers/topics.php";
    $pm->render('topic.html.twig', ['title' => $title, 'description' => $description,
    'nickname'=> $nickname, 'nbpost' => $nbpost, 'level' => $level, 'is_working' => $is_working, 
    'forum' => $forum, 'last_messages' => $list_last_message, 'topics' => $topics, 'avatar' => $avatar,
    'pagination1' => $pagination1, 'pagination2' => $pagination2]);
}, "topic_url")->with("nb", "[1-9]+");

$app->get("/forum/:nbf/topic-:nbt/:paget", function($id_forum, $id_topic, $page_topic) use ($app){
    require __DIR__ . "/controllers/messages.php";
    $pm->render('message.html.twig', ['title' => $title, 'description' => $description,
    'nickname'=> $nickname, 'nbpost' => $nbpost, 'level' => $level, 'is_working' => $is_working, 
    'messages' => $messages, 'pagination1' => $pagination1, 'pagination2' => $pagination2]);
}, "topic_url")->with("nb", "[1-9]+")->with("topic", "[1-9]+");


$app->run();

?>