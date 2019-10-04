<?php

namespace App\Database;

require_once(dirname(__DIR__, 2) . "/common.php");
require_once(__DIR__ . "/init.php");

abstract class Connect {
    
    /**
     * Methode statique d'appel à la connexion
     */
    protected static function getPDO()
    {
        $link = null;
        try
        {
            $link = new \PDO("mysql:host=localhost;dbname=" . BDD , USER, MDP);
            $link->exec("SET NAMES UTF8");
        }
        catch(\PDOException $exep)
        {
            print("Erreur de connexion PDO : " . $exep->getMessage() . "</br>");
            die();
        }
        return $link;
    }

    protected static function destructPDO($link)
    {
        $link = null;
        return $link;
    }
}

class ConnectInstance {

    protected $link;
    private $bdd, $username, $password;

    /**
     * Methode d'appel PDO avec instance
     */
    public function __construct($bdd = BDD, $username = USER, $password = MDP)
    {
        $this->bdd = $bdd;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    public function connect()
    {
        try
        {
            $this->link = new \PDO("mysql:host=localhost;dbname=" . $this->bdd , $this->username, $this->password);
            $this->link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->link->exec("SET NAMES UTF8");
        }
        catch(\PDOException $exep)
        {
            print("Erreur de connexion PDO : " . $exep->getMessage() . "</br>");
            die();
        }
        
    }

    public function __sleep()
    {
        return array('bdd', 'username', 'password');
    }

    public function __wakeup()
    {
        $this->connect();
    }

    public function __destruct()
    {
        $this->link = null;
    }
}