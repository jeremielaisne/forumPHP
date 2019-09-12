<?php

namespace App\Cookie;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 2) . "/init.php");

class PageMaker
{
    private $usercookie;
    private $title;
    private $description;

    function __construct($title = null, $description = null)
    {
        $this->usercookie = new UserCookie();
        $this->title = $title;
        $this->description = $description;
        return $this;
    }

    /**
     * Affichage du header d'une page
     */
    public function start()
    {
        require_once(dirname(__DIR__, 2) . "/views/header.php");
    }

    /**
     * Affichage du footer d'une page
     */
    public function end()
    {
        require_once(dirname(__DIR__, 2) . "/views/footer.php");
    }

    /**
     * Getters et Setters
     */
    public function getUsercookie()
    {
        return $this->usercookie;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle($title) : void
    {
        $this->title = $title;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription($description) : void
    {
        $this->description = $description;
    }
}

?>