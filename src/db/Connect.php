<?php

namespace App\Database;

require_once(__DIR__ . "/init.php");

class Connect {

    protected static function getPDO()
    {
        $db = null;
        try
        {
            $db = new \PDO("mysql:host=localhost;dbname=" . BDD , USER, MDP);
            $db->exec("SET NAMES UTF8");
        }
        catch(\PDOException $exep)
        {
            die($exep->getMessage());
        }
        return $db;
    }
}