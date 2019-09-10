<?php

namespace App;

/**
 * Création et gestion d'un utilisateur
 * 
 * @author Laisné Jérémie <laisne.jeremie83@gmail.com>
 */
class User {

    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $nbpost;
    private $is_connect;
    private $created_at;
    private $updated_at;

    function __construct($id = null, $firstname = null, $lastname = null, $email = null, $nbpost = null, $is_connect = false, $created_at = null, $updated_at = null)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->nbpost = $nbpost;
        $this->is_connect = $is_connect;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at; 
        return $this;
    }

    /* Getters et Setters */
    function getFirstname() : String 
    {
        return $this->firstname;
    }

    function setFirstname($firstname) : void
    {
        $this->firstname = $firstname;
    }

    function getLastname() : String 
    {
        return $this->lastname;
    }

    function setLastname($lastname) : void
    {
        $this->lastname = $lastname;
    }

    function getEmail() : String 
    {
        return $this->email;
    }

    function setEmail($email) : void
    {
        $this->email = $email;
    }

    function getIsConnect() : bool 
    {
        return $this->is_connect;
    }

    function setIsConnect($is_connect) : void
    {
        $this->is_connect = $is_connect;
    }

    function getNbPost() : int 
    {
        return $this->nbpost;
    }

    function setNbPost($nbpost) : void
    {
        $this->nbpost = $nbpost;
    }

    function getCreatedAt() : DateTime
    {
        return $this->created_at;
    }

    function setCreatedAt($created_at) : void
    {
        $this->created_at = $created_at;
    }

    function getUpdatedAt() : DateTime 
    {
        return $this->updated_at;
    }

    function setUpdatedAt($updated_at) : void
    {
        $this->updated_at = $updated_at;
    }

    /* Methodes */

    /**
     * Affectation des variables
     * 
     * @return bool
     */
    function load()
    {
        $db = getPDO();
        $smt = $db->prepare(
            "SELECT 
                firstname,
                lastname,
                email,
                nbpost,
                is_connect,
                created_at,
                updated_at
             FROM
                user
             WHERE
                id = :id"
        );
        $smt->bindValue("id", $this->id, \PDO::PARAM_INT);
        $smt-execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {   
            $this->id = $row["id"];
            $this->firstname = $row["firstname"];
            $this->lastname = $row["lastname"];
            $this->email = $row["email"];
            $this->nbpost = $row["nbpost"];
            $this->is_connect = $row["is_connect"];
            $this->created_at = $row["created_at"];
            $this->updated_at = $row["updated_at"];
        }
        return false;
    }

    /**
     * 
     * Vérification si un utilisateur existe
     * 
     * @return bool
     */
    function isExist()
    {
        $db = getPDO();
        $smt = $db->prepare("SELECT 1 FROM user WHERE id = :id");
        $smt->bindParam("id", $this->id, \PDO::PARAM_INT);
        $smt->execute();
        if ($smt->rowCount())
        {
            return true;
        }
        return false;
    }

    /**
     * 
     * Création d'un nouvel utilisateur
     * 
     * @return bool
     */
    function create()
    {
        $db = getPDO();
        $smt = $db->prepare(
            "INSERT INTO user(
                firstname,
                lastname,
                email,
                nbpost,
                is_connect,
                created_at
            ) VALUES (
                :firstname,
                :lastname,
                :email,
                :nbpost,
                :is_connect,
                NOW()
            )"
        );
        $smt->bindValue("firstname", $this->firstname, \PDO::PARAM_STR);
        $smt->bindValue("lastname", $this->lastname, \PDO::PARAM_STR);
        $smt->bindValue("email", $this->email, \PDO::PARAM_STR);
        $smt->bindValue("nbpost", $this->nbpost, \PDO::PARAM_INT);
        $smt->bindValue("is_connect", $this->is_connect, \PDO::PARAM_BOOL);
        if($smt->execute())
        {
            $this->id = $db->lastInsertId();
            return true;
        }
        return false;
    }
}