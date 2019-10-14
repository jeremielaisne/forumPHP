<?php

namespace App;

use App\Database\Connect;
use DateTime;

class Message extends Connect
{
    private $id;
    private $content;
    private $is_reported;
    private $is_deleted;
    private $id_author;
    private $id_topic;
    private $created_at;
    private $updated_at;

    protected $db;

    function __construct($content = null, $is_reported = false, $is_deleted = false, $id_author = null, $id_topic = null, $created_at = null, $updated_at = null)
    {
        $this->content = $content;
        $this->is_reported = $is_reported;
        $this->is_deleted = $is_deleted;
        $this->id_author = $id_author;
        $this->id_topic = $id_topic;
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

    function setId($id) : void
    {
        $this->id = $id;
    }

    function getContent() : string
    {
        return $this->content;
    }

    function setContent($content) : void
    {
        $this->content = $content;
    }

    function getIsReported() : bool
    {
        return $this->is_reported;
    }

    function setIsReported($is_reported) : void
    {
        $this->is_reported = $is_reported;
    }

    function getIsDeleted() : bool
    {
        return $this->is_deleted;
    }

    function setIsDeleted($is_deleted) : void
    {
        $this->is_deleted = $is_deleted;
    }

    function getAuthor() : string
    {
        return $this->id_author;
    }

    function setAuthor($id_author) : void
    {
        $this->id_author = $id_author;
    }

    function getTopic() : int
    {
        return $this->id_topic;
    }

    function setTopic(int $id_topic) : void
    {
        $this->id_topic = $id_topic;
    }

    function getCreatedAt() : ?Datetime
    {
        if ($this->created_at != null)
        {
            return new DateTime($this->created_at);
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
            return new DateTime($this->updated_at);
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
     * Methodes
     */

    public function load()
    {
        $smt = $this->db->prepare(
            "SELECT
                content,
                is_reported,
                is_deleted,
                id_author,
                id_topic,
                created_at,
                updated_at
             FROM
                message
             WHERE
                id = :id
        ");
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_INT);
        $smt->execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $this->setContent($row["content"]);
            $this->setIsReported($row["is_reported"]);
            $this->setIsDeleted($row["is_deleted"]);
            $this->setAuthor($row["id_author"]);
            $this->setTopic($row["id_topic"]);
            $this->setCreatedAt($row["created_at"]);
            $this->setUpdatedAt($row["updated_at"]);
        }
        return $this;
    }

    public function isExist()
    {
        $smt = $this->db->prepare("SELECT 1 FROM message WHERE :id = id");
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_INT);
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
            "INSERT INTO message(
                content,
                is_reported,
                is_deleted,
                id_author,
                id_topic,
                created_at
            )VALUES(
                :content,
                :is_reported,
                :is_deleted,
                :id_author,
                :id_topic,
                NOW()
            )");
        $smt->bindValue(":content", $this->getContent(), \PDO::PARAM_STR);
        $smt->bindValue(":is_reported", $this->getIsReported(), \PDO::PARAM_BOOL);
        $smt->bindValue(":is_deleted", $this->getIsDeleted(), \PDO::PARAM_BOOL);
        $smt->bindValue(":id_author", $this->getAuthor(), \PDO::PARAM_INT);
        $smt->bindValue(":id_topic", $this->getTopic(), \PDO::PARAM_INT);

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
                message 
            SET
                content = :content,
                is_reported = :is_reported,
                is_deleted = :is_deleted,
                id_author = :id_author,
                id_topic = :id_topic,
                updated_at = NOW()
            WHERE
                id = :id"
        );
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_INT);
        $smt->bindValue(":content", $this->getContent(), \PDO::PARAM_STR);
        $smt->bindValue(":is_reported", $this->getIsReported(), \PDO::PARAM_BOOL);
        $smt->bindValue(":is_deleted", $this->getIsDeleted(), \PDO::PARAM_BOOL);
        $smt->bindValue(":id_author", $this->getAuthor(), \PDO::PARAM_INT);
        $smt->bindValue(":id_topic", $this->getTopic(), \PDO::PARAM_INT);
        if ($smt->execute())
        {
            return true;
        }
        return false;
    }
}