<?php

namespace App\Cookie;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 2) . "/common.php");

class PageMaker
{
    private $loader;
    private $twig;
    private $usercookie;

    function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('views');
        $this->twig = new \Twig\Environment($this->loader, [
            'cache' => false,
        ]);
        $this->usercookie = new UserCookie();
        return $this;
    }

    /**
     * Affichage du contenu d'une page 
     */
    public function render($page, $arg_var = null)
    {
        echo $this->twig->render($page, $arg_var);
    }

    /**
     * Getters Cookies
     */
    public function getUsercookie()
    {
        return $this->usercookie;
    }
}

?>