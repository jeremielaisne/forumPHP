<?php

namespace App;

use App\Database\Connect;
use DateTime;

/**
 * Création et gestion d'un utilisateur
 * 
 * @author Laisné Jérémie <laisne.jeremie83@gmail.com>
 */
class Forum extends Connect
{
    private $id;
    private $name;
    private $active;
    private $id_author;
    private $orderc;
    private $nbTopic;
    private $nbTopicModeration;
    private $isDeleted;
    private $created_at;
    private $updated_at;

    protected $db;

    function __construct(int $id = null, string $name = null, bool $active = null, int $id_author = null, int $orderc = null, int $nbTopic = 0, int $nbTopicModeration = 0, bool $isDeleted = false, datetime $created_at = null, datetime $updated_at = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->active = $active;
        $this->id_author = $id_author;
        $this->orderc = $orderc;
        $this->nbTopic = $nbTopic;
        $this->nbTopicModeration = $nbTopicModeration;
        $this->isDeleted = $isDeleted;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;

        $this->db = self::getPDO();
        return $this;
    }

    /**
     * Getters et Setters
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

    function getActive() : bool
    {
        return $this->active;
    }

    function setActive(bool $active) : void
    {
        $this->active = $active;
    }

    function getAuthor() : ?int
    {
        return $this->id_author;
    }

    function setAuthor(int $id_author) : void
    {
        $this->id_author = $id_author;
    }

    function getOrderc() : int
    {
        return $this->orderc;
    }

    function setOrderc(int $orderc) : void
    {
        $this->orderc = $orderc;
    }

    function getNbTopic() : int
    {
        return $this->nbTopic;
    }

    function setNbTopic(int $nbTopic) : void
    {
        $this->nbTopic = $nbTopic;
    }

    function getNbTopicModeration() : int
    {
        return $this->nbTopicModeration;
    }

    function setNbTopicModeration(int $nbTopicModeration) : void
    {
        $this->nbTopicModeration = $nbTopicModeration;
    }

    function getIsDeleted() : bool
    {
        return $this->isDeleted;
    }

    function setIsDeleted(bool $isDeleted) : void
    {
        $this->isDeleted = $isDeleted;
    }

    function getCreatedAt() : datetime
    {
        return $this->created_at;
    }

    function setCreatedAt(datetime $created_at) : void
    {
        $this->created_at = $created_at;
    }

    function getUpdatedAt() : ?datetime
    {
        return $this->updated_at;
    }

    function setUpdatedAt(datetime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /*** Méthodes */

    /**
     * Initialisation et affectation des variables
     * 
     * @return obj new Forum
     */
    function load()
    {
        $smt = $this->db->prepare(
            "SELECT 
                name,
                active,
                id_author,
                orderc,
                nbTopic,
                nbTopicModeration,
                isDeleted,
                created_at
             FROM 
                Forum 
             WHERE 
                id = :id");
        $smt->bindValue("id", $this->id, \PDO::PARAM_INT);
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $forum = new Forum;
            $forum->setId($this->id);
            $forum->setid_author($row["id_author"]);
            $forum->setActive($row["active"]);
            $forum->setorderc($row["orderc"]);
            $forum->setNbTopic($row["nbTopic"]);
            $forum->setNbTopicModeration($row["nbTopicModeration"]);
            $forum->setIsDeleted($row["isDeleted"]);
            $forum->setCreatedAt($row["created_at"]);
            $forum->setUpdatedAt($row["updated_at"]);
        }
        return $forum;
    }

    /**
     * Test l'existance d'un forum
     * 
     * @return bool
     */
    function isExist()
    {
        $smt = $this->db->prepare("SELECT 1 FROM Forum WHERE id = :id");
        $smt->bindValue("id", $this->id, \PDO::PARAM_INT);
        if ($smt->rowCount())
        {
            return true;
        }
        return false;
    }

    /**
     * Création d'un nouveau forum
     * 
     * @return bool
     */
    function create()
    {
        $smt = $this->db->prepare(
            "INSERT INTO forum(
                name,
                active,
                id_author,
                orderc,
                nbTopic,
                nbTopicModeration,
                isDeleted,
                created_at
            )VALUES(
                :name,
                :active,
                :id_author,
                :orderc,
                :nbTopic,
                :nbTopicModeration,
                :isDeleted,
                NOW()
            )");
        $smt->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $smt->bindValue(":active", $this->active, \PDO::PARAM_BOOL);
        $smt->bindValue(":id_author", $this->id_author, \PDO::PARAM_INT);
        $smt->bindValue(":orderc", $this->orderc, \PDO::PARAM_INT);
        $smt->bindValue(":nbTopic", $this->nbTopic, \PDO::PARAM_INT);
        $smt->bindValue(":nbTopicModeration", $this->nbTopicModeration, \PDO::PARAM_INT);
        $smt->bindValue(":isDeleted", $this->isDeleted, \PDO::PARAM_BOOL);
 
        if($smt->execute())
        {
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Suppression d'un forum
     * 
     * @return bool
     */
    function delete()
    {
        $smt = $this->db->prepare("DELETE FROM forum WHERE id = :id");
        $smt->bindValue(":id", $this->id, \PDO::PARAM_INT);
        if($smt->execute())
        {
            return true;
        }
        return false;
    }

    /**
     * Mis à jour d'un forum
     * 
     */
    function update()
    {
        $smt = $this->db->prepare(
            "UPDATE 
                forum 
            SET 
                name = :name,
                active = :active,
                id_author = :id_author,
                orderc = :orderc,
                nbTopic = :nbTopic,
                nbTopicModeration = :nbTopicModeration,
                isDeleted = :isDeleted,
                updated_at = :updated_at
            WHERE
                id = :id
        ");
        $smt->bindValue(":id", $this->id, \PDO::PARAM_ID);
        $smt->bindValue(":name", $this->name, \PDO::PARAM_NAME);
        $smt->bindValue(":active", $this->active, \PDO::PARAM_BOOL);
        $smt->bindValue(":id_author", $this->id_author, \PDO::PARAM_STR);
        $smt->bindValue(":orderc", $this->orderc, \PDO::PARAM_INT);
        $smt->bindValue(":nbTopic", $this->nbTopic, \PDO::PARAM_INT);
        $smt->bindValue(":nbTopicModeration", $this->nbTopicModeration, \PDO::PARAM_INT);
        $smt->bindValue(":isDeleted", $this->isDeleted, \PDO::PARAM_BOOL);
        $smt->bindValue(":updated", NOW());
        if ($smt->execute())
        {
            return true;
        }
        return false;
    }
}