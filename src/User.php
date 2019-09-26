<?php

namespace App;

use App\Database\Connect;
use DateTime;
use phpDocumentor\Reflection\Types\Boolean;

include(__DIR__ . "/db/Connect.php");

/**
 * Création et gestion d'un utilisateur
 * 
 * @author Laisné Jérémie <laisne.jeremie83@gmail.com>
 */
class User extends Connect{

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
        if ($this->updated_at != null)
        {
            return $this->updated_at;
        }
        return new DateTime();
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
    function load() : User
    {
        $db = Connect::getPDO();
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
    function isExist() : bool
    {
        $db = Connect::getPDO();
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
    function create() : bool
    {
        $db = Connect::getPDO();
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
        $smt->bindValue("email", self::generatePassword(), \PDO::PARAM_STR);
        $smt->bindValue("mdp", $this->mdp, \PDO::PARAM_STR);
        $smt->bindValue("nbpost", 0, \PDO::PARAM_INT);
        $smt->bindValue("is_connect", true, \PDO::PARAM_BOOL);
        if($smt->execute())
        {
            $this->id = $db->lastInsertId();
        }
        return false;
    }

    /**
     * Mis à jour d'un utilisateur
     * 
     * @return bool
     */
    function update() : bool
    {
        $db = Connect::getPDO();
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
     * 
     * Vérification si un mail existe deja en bdd
     * 
     * @var $email: la boite mail
     * 
     * @return bool
     */
    public static function verifyUniqueEmail($email) : bool
    {
        $db = Connect::getPDO();
        $smt = $db->prepare("SELECT 1 FROM USER WHERE email = :email");
        $smt->bindParam(":email", $email, \PDO::PARAM_STR);

        if(!$smt->rowCount())
        {
            return true;
        }
        return false;
    }

    /**
     * 
     * Vérification si un mot de passe existe deja en bdd
     * 
     * @var $mdp: le mot de passe
     * 
     * @return bool
     */
    public static function verifyUniquePassword($mdp) : bool
    {
        $db = Connect::getPDO();
        $smt = $db->prepare("SELECT 1 FROM USER WHERE mdp = :mdp");
        $smt->bindParam(":mdp", $mdp, \PDO::PARAM_STR);

        if($smt->rowCount() === 0)
        {
            return true;
        }
        return false;
    }

    /**
     * Génération d'un mot de passe unique en bdd lors de l'inscription
     * 
     */
    public static function generatePassword()
    {
        $key = "";
        $alphanum = "abcdefghijklmnopqrstuvwxyz0123456789";
        for ($i=0; $i<12; $i++)
        {
            $i == mt_rand(0,2) ? $tmp = $alphanum[mt_rand(0, 35)] : $tmp = "";
            $i == 2 ? $key .= '$' : $i == mt_rand(4,6) ? $key .= "#^"  : $key .= $alphanum[mt_rand(0, 35)] . $tmp;
        }
        if (self::verifyUniquePassword($key))
        {
            /**
             * Envoyer mdp par mail
             * 
             */
            echo "$key\r\n";
            return sha1($key);
        }
        return self::generatePassword();
    }

    /**
     * 
     * Vérifie qu'un utlisateur est bien présent dans la base de données
     * 
     * @var $email: la boite mail, $mdp: le mot de passe
     * 
     * @return int $id de l'utiliateur
     */
    public static function isValidLogin($mdp) : int
    {
        $id_user = 0;
        $db = Connect::getPDO();

        $smt = $db->prepare("SELECT id FROM user WHERE mdp = :mdp");
        $smt->bindValue("mdp", sha1($mdp), \PDO::PARAM_STR);
        $smt->execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $id_user = $row["id"];
        }
        return $id_user;
    }
}