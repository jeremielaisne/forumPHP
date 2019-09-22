<?php

namespace App\Cookie;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 2) . "/init.php");

use App\User;

class UserCookie 
{
    private $cookie;
    private $isConnect;
    private $user;

    public function __construct() 
    {
        $this->cookie = null;
        $this->isConnect = false;
        $this->user = null;
        return $this->init();
    }

    /**
     * Getters
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    public function getIsConnect() : bool
    {
        return $this->isConnect;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function init() 
    {
        if (isset($_COOKIE["testForumCookie"]) && !empty($_COOKIE["testForumCookie"]))
        {
            $this->cookie = $_COOKIE["testForumCookie"];
            return $this->check();
        }
        return false;
    }

    /**
     * Vérification des informations présents dans le cookie
     * 
     */
    public function check() 
    {
        $pos = strpos($this->cookie, "$");
        $id_user = substr($this->cookie, 0, $pos);
        $key_user = substr($this->cookie, $pos+1);

        $sha1key = self::keyUser($id_user);
        if ($sha1key === $key_user)
        {
            $user = new User;
            $user->setId($id_user);
            if ($user->isExist() && $user->load())
            {
                $this->isConnect = true;
                $this->user = $user;
                return true;
            }
        }
        self::erase();
        return false;
    }

    /**
     * Création d'un cookie utilisateur
     * 
     * @param $id de l'utilisateur
     * 
     */
    public static function create($id)
    {
        $sha1key = self::keyUser($id);
        return setcookie("testForumCookie", $id . '$' . $sha1key, time() + (30 * 24 * 3600), "/");
    }

    /**
     * Suppression d'un cookie utilisateur
     * 
     */
    public static function erase() 
    {
        setcookie("testForumCookie", "", time() - (30 * 24 * 3600), "/");
        unset($_COOKIE['testForumCookie']);
    }

    /**
     * Clé de l'utilisateur
     * 
     */
    public static function keyUser($id)
    {
        return sha1('ghtçà' . $id . 'ki6&@tyç');
    }
}