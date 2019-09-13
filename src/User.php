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
    private $mdp;
    private $nbpost;
    private $is_connect;
    private $created_at;
    private $updated_at;

    function __construct($id = null, $firstname = null, $lastname = null, $email = null, $mdp = null, $nbpost = null, $is_connect = false, $created_at = null, $updated_at = null)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->nbpost = $nbpost;
        $this->is_connect = $is_connect;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at; 
        return $this;
    }

    /* Getters et Setters */
    function getId() : int 
    {
        return $this->id;
    }

    function setId($id) : void
    {
        $this->id = $id;
    }

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

    function getMdp() : String 
    {
        return $this->mdp;
    }

    function setMdp($mdp) : void
    {
        $this->mdp = $mdp;
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
     * @return obj User
     */
    function load()
    {
        $db = getPDO();
        $smt = $db->prepare(
            "SELECT
                id,
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
        $smt->execute();
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
        return $this;
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
                mdp,
                nbpost,
                is_connect,
                created_at
            ) VALUES (
                :firstname,
                :lastname,
                :email,
                :mdp,
                :nbpost,
                :is_connect,
                NOW()
            )"
        );
        $smt->bindValue("firstname", $this->firstname, \PDO::PARAM_STR);
        $smt->bindValue("lastname", $this->lastname, \PDO::PARAM_STR);
        $smt->bindValue("email", $this->email, \PDO::PARAM_STR);
        $smt->bindValue("mdp", $this->mdp, \PDO::PARAM_STR);
        $smt->bindValue("nbpost", 0, \PDO::PARAM_INT);
        $smt->bindValue("is_connect", true, \PDO::PARAM_BOOL);
        if($smt->execute())
        {
            $this->id = $db->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Mis à jour d'un utilisateur
     * 
     * @return bool
     */
    function update()
    {
        $db = getPDO();
        $smt = $db->prepare(
            "UPDATE 
                user 
            SET
                firstname = :firstname,
                lastname = :lastname,
                mdp = :mdp,
                email = :email,
                nbpost = :nbpost,
                is_connect = :is_connect,
                updated_at = NOW()
            WHERE 
                id = :id_user
        ");
        $smt->bindValue("id_user", $this->id, \PDO::PARAM_INT);
        $smt->bindValue("firstname", $this->firstname, \PDO::PARAM_STR);
        $smt->bindValue("lastname", $this->lastname, \PDO::PARAM_STR);
        $smt->bindValue("mdp", $this->mdp, \PDO::PARAM_STR);
        $smt->bindValue("email", $this->email, \PDO::PARAM_STR);
        $smt->bindValue("nbpost", $this->nbpost, \PDO::PARAM_INT);
        $smt->bindValue("is_connect", $this->is_connect, \PDO::PARAM_BOOL);
        if ($smt->execute())
        {
            return true;
        }
        return false;
    }

    /**
     * Vérifie qu'un utlisateur est bien présent dans la base de données
     * 
     * @param $email: la boite mail, $mdp: le mot de passe
     * 
     * @return int $id de l'utiliateur
     */
    public static function isValidLogin($email, $mdp)
    {
        $id_user = null;
        $db = getPDO();

        $smt = $db->prepare("SELECT id FROM user WHERE email = :email AND mdp = :mdp");
        $smt->bindValue("email", $email, \PDO::PARAM_STR);
        $smt->bindValue("mdp", $mdp, \PDO::PARAM_STR);
        $smt->execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $id_user = $row["id"];
        }

        return $id_user;
    }
}