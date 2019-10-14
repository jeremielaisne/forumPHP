<?php

namespace App;

use App\Database\Connect;
use DateTime;

class Topic extends Connect{

    private $id;
    private $name;
    private $active;
    private $nb_view;
    private $nb_message;
    private $nb_message_moderator;
    private $is_pin;
    private $is_locked;
    private $is_deleted;
    private $id_forum;
    private $id_author;
    private $id_last_author;
    private $created_at;
    private $updated_at;

    protected $db;

    function __construct($id = null, $name = null, $active = null, $nb_view = null, $nb_message = null, $nb_message_moderator = null, $is_pin = false, $is_locked = false, $is_deleted = null, $id_forum = null, $id_author = null, $id_last_author = null, $created_at = null, $updated_at = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->active = $active;
        $this->nb_view = $nb_view;
        $this->nb_message = $nb_message;
        $this->nb_message_moderator = $nb_message_moderator;
        $this->is_pin = $is_pin;
        $this->is_locked = $is_locked;
        $this->is_deleted = $is_deleted;
        $this->id_forum = $id_forum;
        $this->id_author = $id_author;
        $this->id_last_author = $id_last_author;
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

    function getNbView() : int
    {
        return $this->nb_view;
    }

    function setNbView(int $nb_view) : void
    {
        $this->nb_view = $nb_view;
    }

    function getNbMessage() : int
    {
        return $this->nb_message;
    }

    function setNbMessage(int $nb_message) : void
    {
        $this->nb_message = $nb_message;
    }

    function getNbMessageModerator() : int
    {
        return $this->nb_message_moderator;
    }

    function setNbMessageModerator(int $nb_message_moderator) : void
    {
        $this->nb_message_moderator = $nb_message_moderator;
    }

    function getIsPin() : bool
    {
        return $this->is_pin;
    }

    function setIsPin(bool $is_pin) : void
    {
        $this->is_pin = $is_pin;
    }

    function getIsLocked() : bool
    {
        return $this->is_locked;
    }

    function setIsLocked(bool $is_locked) : void
    {
        $this->is_locked = $is_locked;
    }

    function getIsDeleted() : bool
    {
        return $this->is_deleted;
    }

    function setIsDeleted(bool $is_deleted) : void
    {
        $this->is_deleted = $is_deleted;
    }

    function getForum() : int
    {
        return $this->id_forum;
    }

    function setForum(int $id_forum) : void
    {
        $this->id_forum = $id_forum;
    }

    function getAuthor() : ?int
    {
        return $this->id_author;
    }

    function setAuthor(int $id_author) : void
    {
        $this->id_author = $id_author;
    }

    function getLastAuthor() : ?int
    {
        return $this->id_last_author;
    }

    function setLastAuthor(int $id_last_author) : void
    {
        $this->id_last_author = $id_last_author;
    }


    function getCreatedAt() : ?DateTime
    {
        return $this->created_at;
    }

    function setCreatedAt($created_at) : void
    {
        $this->created_at = $created_at;
    }

    function getUpdatedAt() : ?DateTime
    {
        return $this->updated_at;
    }

    function setUpdatedAt($updated_at) : void
    {
        $this->updated_at = $updated_at;
    }

    function getDB() : ?\PDO
    {
        return $this->db;
    }

    /**
     * Methodes
     */
    public function load()
    {
        $smt = $this->db->prepare(
            "SELECT
                name,
                active,
                nb_view,
                nb_message,
                nb_message_moderator,
                is_pin,
                is_locked,
                is_deleted,
                id_forum,
                id_author,
                id_last_author,
                created_at,
                updated_at
             FROM
                topic
             WHERE
                id = :id"
        );
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_STR);
        $smt->execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $this->setName($row["name"]);
            $this->setActive($row["active"]);
            $this->setNbView($row["nb_view"]);
            $this->setNbMessage($row["nb_message"]);
            $this->setNbMessageModerator($row["nb_message_moderator"]);
            $this->setIsPin($row["is_pin"]);
            $this->setIsLocked($row["is_locked"]);
            $this->setIsDeleted($row["is_deleted"]);
            $this->setForum($row["id_forum"]);
            $this->setAuthor($row["id_author"]);
            $this->setLastAuthor($row["id_last_author"]);
            $this->setCreatedAt($row["created_at"]);
            $this->setUpdatedAt($row["updated_at"]);
        }
        return $this;
    }

    public function isExist()
    {
        $smt = $this->db->prepare("SELECT 1 FROM topic WHERE id = :id");
        $smt->bindValue("id", $this->getId(), \PDO::PARAM_INT);
        $smt->execute();
        if ($smt->rowCount())
        {
            return true;
        }
        return false;
    }

    public function create()
    {
        $smt = $this->db->prepare(
            "INSERT INTO topic(
                name,
                active,
                nb_view,
                nb_message,
                nb_message_moderator,
                is_pin,
                is_locked,
                is_deleted,
                id_forum,
                id_author,
                id_last_author,
                created_at
            )VALUES(
                :name,
                :active,
                :nb_view,
                :nb_message,
                :nb_message_moderator,
                :is_pin,
                :is_locked,
                :is_deleted,
                :id_forum,
                :id_author,
                :id_last_author,
                NOW()
            )");
        $smt->bindValue(":name", $this->getName(), \PDO::PARAM_STR);
        $smt->bindValue(":active", $this->getActive(), \PDO::PARAM_BOOL);
        $smt->bindValue(":nb_view", $this->getNbView(), \PDO::PARAM_INT);
        $smt->bindValue(":nb_message", $this->getNbView(), \PDO::PARAM_INT);
        $smt->bindValue(":nb_message_moderator", $this->getNbMessageModerator(), \PDO::PARAM_INT);
        $smt->bindValue(":is_pin", $this->getIsPin(), \PDO::PARAM_BOOL);
        $smt->bindValue(":is_locked", $this->getIsLocked(), \PDO::PARAM_BOOL);
        $smt->bindValue(":is_deleted", $this->getIsDeleted(), \PDO::PARAM_BOOL);
        $smt->bindValue(":id_forum", $this->getForum(), \PDO::PARAM_INT);
        $smt->bindValue(":id_author", $this->getAuthor(), \PDO::PARAM_INT);
        $smt->bindValue(":id_last_author", $this->getLastAuthor(), \PDO::PARAM_INT);

        if ($smt->execute())
        {
            $this->setId((int)$this->db->lastInsertId());
            return true;
        }
        return false;
    }

    public function update()
    {
        $smt = $this->db->prepare(
            "UPDATE 
                topic
            SET
                name = :name,
                active = :active,
                nb_view = :is_pin,
                nb_message = :nb_message,
                nb_message_moderator = :nb_message_moderator,
                is_pin = :is_pin,
                is_locked = :is_locked,
                is_deleted = :is_deleted,
                id_forum = :id_forum,
                id_author = :id_author,
                id_last_author = :id_last_author,
                updated_at = NOW()
            WHERE
                id = :id"
        );
        $smt->bindValue("id", $this->getId(), \PDO::PARAM_STR);
        $smt->bindValue("name", $this->getName(), \PDO::PARAM_STR);
        $smt->bindValue("active", $this->getActive(), \PDO::PARAM_BOOL);
        $smt->bindValue("nb_view", $this->getNbView(), \PDO::PARAM_INT);
        $smt->bindValue("nb_message", $this->getNbMessage(), \PDO::PARAM_INT);
        $smt->bindValue("nb_message_moderator", $this->getNbMessageModerator(), \PDO::PARAM_INT);
        $smt->bindValue("is_pin", $this->getIsPin(), \PDO::PARAM_BOOL);
        $smt->bindValue("is_locked", $this->getIsLocked(), \PDO::PARAM_BOOL);
        $smt->bindValue("is_deleted", $this->getIsDeleted(), \PDO::PARAM_BOOL);
        $smt->bindValue("id_forum", $this->getForum(), \PDO::PARAM_INT);
        $smt->bindValue("id_author", $this->getAuthor(), \PDO::PARAM_INT);
        $smt->bindValue("id_last_author", $this->getLastAuthor(), \PDO::PARAM_INT);

        if ($smt->execute())
        {
            return true;
        }
        return false;
    }
}