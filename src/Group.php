<?php

namespace App;

use App\Database\Connect;
use DateTime;

/**
 * Création et gestion d'un utilisateur
 * 
 * @author Laisné Jérémie <laisne.jeremie83@gmail.com>
 */
class Group extends Connect
{
    private $id;
    private $name;
    private $orderc;
    private $created_at;
    private $updated_at;

    protected $db;

    function __construct(int $id = null, string $name = null, int $orderc = null, dateTime $created_at = null, dateTime $updated_at = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->orderc = $orderc;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;

        $this->db = self::getPDO();
        return $this;
    }

    /**
     * Getter et Setter
     */
    function getId() : int
    {
        return $this->id;
    }

    function setId(int $id) : void
    {
        $this->id = $id;
    }

    function getName() : string
    {
        return $this->name;
    }

    function setName(string $name) : void
    {
        $this->name = $name;
    }
        
    function getOrderc() : int
    {
        return $this->orderc;
    }

    function setOrderc(int $orderc) : void
    {
        $this->orderc = $orderc;
    }

    function getCreatedAt()
    {
        if ($this->created_at != null)
        {
            return textDatetime($this->created_at);
        }
        return null;
    }

    function setCreatedAt($created_at) : void
    {
        $this->created_at = $created_at;
    }

    function getUpdatedAt() : ?Datetime
    {
        if ($this->updated_at != null)
        {
            return $this->updated_at;
        }
        return null;
    }

    function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getDB() : ?\PDO
    {
        return $this->db;
    }

    /**
     * Initialisation et affectation des variables
     * 
     * @return obj new Group
     */
    function load() : Group
    {
        $smt = $this->db->prepare(
            "SELECT 
                name,
                orderc,
                created_at,
                updated_at
             FROM 
                groupforum
             WHERE 
                id = :id");
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_INT);
        $smt->execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $this->setName($row["name"]);
            $this->setOrderc($row["orderc"]);
            $this->setCreatedAt($row["created_at"]);
            $this->setUpdatedAt($row["updated_at"]);
        }
        return $this;
    }

    /**
     * Test l'existance d'un forum
     * 
     * @return bool
     */
    function isExist() : bool
    {
        $smt = $this->db->prepare("SELECT 1 FROM groupforum WHERE id = :id");
        $smt->bindValue("id", $this->getId(), \PDO::PARAM_INT);
        $smt->execute();
        if ($smt->rowCount())
        {
            return true;
        }
        return false;
    }

    /**
     * Création d'un nouveau groupe de forum
     * 
     * @return bool
     */
    function create() : bool
    {
        $smt = $this->db->prepare(
            "INSERT INTO groupforum(
                name,
                orderc,
                created_at
            )VALUES(
                :name,
                :orderc,
                NOW()
            )");
        $smt->bindValue(":name", $this->getName(), \PDO::PARAM_STR);
        $smt->bindValue(":orderc", $this->getOrderc(), \PDO::PARAM_INT);
        if($smt->execute())
        {
            $this->setId((int)$this->db->lastInsertId());
            return true;
        }
        return false;
    }

    /**
     * Calcul nb de groups
     * 
     *  @return int
     */
    public static function getNbGroups() : ?int
    {
        $db = Connect::getPDO();
        $smt = $db->prepare("SELECT 1 from groupforum");
        if($smt->execute())
        {
            return $smt->rowCount();
        }
        return 0;
    }
}