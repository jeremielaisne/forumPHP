<?php

namespace App;

use App\Database\Connect;
use App\Mailer\Mailling;
use DateTime;
/**
 * Création et gestion d'un utilisateur
 * 
 * @author Laisné Jérémie <laisne.jeremie83@gmail.com>
 */
class User extends Connect {

    private $id;
    private $nickname;
    private $firstname;
    private $lastname;
    private $email;
    private $avatar;
    private $statusc;
    private $lvl;
    private $mdp;
    private $nbpost;
    private $is_working;
    private $is_connect;
    private $created_at;
    private $updated_at;
    private $ip;

    protected $db;

    function __construct($id = null, $nickname = null, $firstname = null, $lastname = null, $email = null, $avatar = null, $statusc = 'INVITE', $lvl = 1, $mdp = null, $nbpost = null, $is_working = false, $is_connect = false, $created_at = null, $updated_at = null)
    {
        $this->id = $id;
        $this->nickname = $nickname;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->statusc = $statusc;
        $this->lvl = $lvl;
        $this->mdp = $mdp;
        $this->nbpost = $nbpost;
        $this->is_working = $is_working;
        $this->is_connect = $is_connect;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->ip = "0.0.0.0";

        $this->db = self::getPDO();
        return $this;
    }

    public function __destruct()
    {
        if (!empty($this->db))
        {
            self::destructPDO($this->db);
        }
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

    function getNickname() : String
    {
        return $this->nickname;
    }

    function setNickname($nickname) : void
    {
        $this->nickname = $nickname;
    }

    function getFirstname() : ?String 
    {
        return $this->firstname;
    }

    function setFirstname($firstname) : void
    {
        $this->firstname = $firstname;
    }

    function getLastname() : ?String 
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

    function getAvatar() : int 
    {
        return $this->avatar;
    }

    function setAvatar($avatar) : void
    {
        $this->avatar = $avatar;
    }

    function getStatus() : String 
    {
        return $this->statusc;
    }

    function setStatus($statusc) : void
    {
        $this->statusc = $statusc;
    }

    function getLvl() : Int 
    {
        return $this->lvl;
    }

    function setLvl($lvl) : void
    {
        $this->lvl = $lvl;
    }

    function getMdp() : String 
    {
        return $this->mdp;
    }

    function setMdp($mdp) : void
    {
        $this->mdp = $mdp;
    }

    function getIsWorking() : bool 
    {
        return $this->is_working;
    }

    function setIsWorking($is_working) : void
    {
        $this->is_working = $is_working;
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

    function getCreatedAt() : ?DateTime
    {
        if ($this->updated_at != null)
        {
            return new DateTime($this->created_at);
        }
        return null;
    }

    function setCreatedAt($created_at) : void
    {
        $this->created_at = $created_at;
    }

    function getUpdatedAt() : ?DateTime
    {
        if ($this->updated_at != null)
        {
            return new DateTime($this->updated_at);
        }
        return null;
    }

    function setUpdatedAt($updated_at) : void
    {
        $this->updated_at = $updated_at;
    }

    function getIp() : string
    {
        return $this->ip;
    }

    function setIp(string $ip) : void
    {
        $this->ip = $ip;
    }

    public function getDB() : ?\PDO
    {
        return $this->db;
    }


    /* Methodes */

    /**
     * Affectation des variables
     * 
     * @return obj User
     */
    function load() : User
    {
        $smt = $this->db->prepare(
            "SELECT
                id,
                nickname,
                firstname,
                lastname,
                email,
                avatar,
                statusc,
                lvl,
                mdp,
                nbpost,
                is_working,
                is_connect,
                created_at,
                updated_at,
                ip
             FROM
                user
             WHERE
                id = :id"
        );
        $smt->bindValue(":id", $this->id, \PDO::PARAM_INT);
        $smt->execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {   
            $this->id = $row["id"];
            $this->nickname = $row["nickname"];
            $this->firstname = $row["firstname"];
            $this->lastname = $row["lastname"];
            $this->email = $row["email"];
            $this->avatar = $row["avatar"];
            $this->statusc = $row["statusc"];
            $this->lvl = $row["lvl"];
            $this->mdp = $row["mdp"];
            $this->nbpost = $row["nbpost"];
            $this->is_working = $row["is_working"];
            $this->is_connect = $row["is_connect"];
            $this->created_at = $row["created_at"];
            $this->updated_at = $row["updated_at"];
            $this->ip = $row["ip"];
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
        $smt = $this->db->prepare("SELECT 1 FROM user WHERE id = :id");
        $smt->bindValue(":id", $this->id, \PDO::PARAM_INT);
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
        $smt = $this->db->prepare(
            "INSERT INTO user(
                nickname,
                firstname,
                lastname,
                email,
                avatar,
                statusc,
                lvl,
                mdp,
                nbpost,
                is_working,
                is_connect,
                ip,
                created_at
            ) VALUES (
                :nickname,
                :firstname,
                :lastname,
                :email,
                :avatar,
                :statusc,
                :lvl,
                :mdp,
                :nbpost,
                :is_working,
                :is_connect,
                :ip,
                NOW()
        )");
        $smt->bindValue(":nickname", $this->nickname, \PDO::PARAM_STR);
        $smt->bindValue(":firstname", $this->firstname, \PDO::PARAM_STR);
        $smt->bindValue(":lastname", $this->lastname, \PDO::PARAM_STR);
        $smt->bindValue(":email", $this->email, \PDO::PARAM_STR);
        $smt->bindValue(":avatar", $this->avatar, \PDO::PARAM_INT);
        $smt->bindValue(":statusc", $this->statusc, \PDO::PARAM_STR);
        $smt->bindValue(":lvl", $this->lvl, \PDO::PARAM_INT);
        $smt->bindValue(":mdp", self::generatePassword(), \PDO::PARAM_STR);
        $smt->bindValue(":nbpost", 0, \PDO::PARAM_INT);
        $smt->bindValue(":is_working", false, \PDO::PARAM_BOOL);
        $smt->bindValue(":is_connect", true, \PDO::PARAM_BOOL);
        $smt->bindValue(":ip", $this->ip, \PDO::PARAM_STR);
        
        if($smt->execute())
        {
            $this->id = $this->db->lastInsertId();
            return true;
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
        $smt = $this->db->prepare(
            "UPDATE 
                user 
            SET
                nickname = :nickname,
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                avatar = :avatar,
                statusc = :statusc,
                lvl = :lvl,
                nbpost = :nbpost,
                is_working = :is_working,
                is_connect = :is_connect,
                ip = :ip,
                updated_at = NOW()
            WHERE 
                id = :id_user
        ");
        $smt->bindValue(":id_user", $this->id, \PDO::PARAM_INT);
        $smt->bindValue(":nickname", $this->nickname, \PDO::PARAM_STR);
        $smt->bindValue(":firstname", $this->firstname, \PDO::PARAM_STR);
        $smt->bindValue(":lastname", $this->lastname, \PDO::PARAM_STR);
        $smt->bindValue(":email", $this->email, \PDO::PARAM_STR);
        $smt->bindValue(":avatar", $this->avatar, \PDO::PARAM_INT);
        $smt->bindValue(":statusc", $this->statusc, \PDO::PARAM_STR);
        $smt->bindValue(":lvl", $this->lvl, \PDO::PARAM_INT);
        $smt->bindValue(":nbpost", $this->nbpost, \PDO::PARAM_INT);
        $smt->bindValue(":is_working", $this->is_working, \PDO::PARAM_BOOL);
        $smt->bindValue(":is_connect", $this->is_connect, \PDO::PARAM_BOOL);
        $smt->bindValue(":ip", $this->ip, \PDO::PARAM_STR);
        if ($smt->execute())
        {
            return true;
        }
        return false;
    }

    /**
     * Mis à jour d'un nouveau mot de passe pour l'utilisateur
     * 
     * @return bool
     */
    function updatePassword() : bool
    {
        $smt = $this->db->prepare(
            "UPDATE 
                user 
            SET
                mdp = :mdp,
                updated_at = NOW()
            WHERE 
                id = :id_user
        ");
        $smt->bindValue(":id_user", $this->id, \PDO::PARAM_INT);
        $smt->bindValue(":mdp", self::generatePassword(), \PDO::PARAM_STR);
        if ($smt->execute())
        {
            return true;
        }
        return false;
    }

    /**
     * 
     * Vérification si un pseudonyme existe deja en bdd
     * 
     * @var $nickname: le pseudonyme
     * 
     * @return bool
     */
    public static function verifyUniqueNickname($nickname) : bool
    {
        $link = self::getPDO();
        $smt = $link->prepare("SELECT 1 FROM USER WHERE nickname = :nickname");
        $smt->bindValue(":nickname", $nickname, \PDO::PARAM_STR);
        $smt->execute();

        if($smt->rowCount() === 0)
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
        $link = self::getPDO();
        $smt = $link->prepare("SELECT 1 FROM USER WHERE email = :email");
        $smt->bindValue(":email", $email, \PDO::PARAM_STR);
        $smt->execute();

        if($smt->rowCount() === 0)
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
        $link = self::getPDO();
        $smt = $link->prepare("SELECT 1 FROM USER WHERE mdp = :mdp");
        $smt->bindValue(":mdp", $mdp, \PDO::PARAM_STR);
        $smt->execute();

        if($smt->rowCount() === 0)
        {
            return true;
        }
        return false;
    }

    /**
     * Envoi d'un email lors de l'inscription
     * 
     */
    public static function generateMail($key)
    {
        $mail = new Mailling();
        $mail->setContent("Votre mot de passe : " . $key);
        //return $mail->send();
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
            if (self::generateMail($key))
            {
                return sha1($key);
            }
            return "ERROR_MAIL_" . $key;
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

        $link = self::getPDO();
        $smt = $link->prepare("SELECT id FROM user WHERE mdp = :mdp");
        $smt->bindValue(":mdp", sha1($mdp), \PDO::PARAM_STR);
        $smt->execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $id_user = $row["id"];
        }
        return $id_user;
    }
}