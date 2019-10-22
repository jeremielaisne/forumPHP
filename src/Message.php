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
    private $name_author;
    private $avatar_author;
    private $id_topic;
    private $name_topic;
    private $url_topic;
    private $created_at;
    private $updated_at;

    protected $db;

    function __construct($content = null, $is_reported = false, $is_deleted = false, $id_author = null, $name_author = null, $avatar_author = null, $id_topic = null, $name_topic = null, $url_topic = null, $created_at = null, $updated_at = null)
    {
        $this->content = $content;
        $this->is_reported = $is_reported;
        $this->is_deleted = $is_deleted;
        $this->id_author = $id_author;
        $this->name_author = $name_author;
        $this->avatar_author = $avatar_author;
        $this->id_topic = $id_topic;
        $this->name_topic = $name_topic;
        $this->url_topic = $url_topic;
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

    function getAuthorId() : int
    {
        return $this->id_author;
    }

    function setAuthorId($id_author) : void
    {
        $this->id_author = $id_author;
    }

    function getAuthorName() : string
    {
        return $this->name_author;
    }

    function setAuthorName($name_author) : void
    {
        $this->name_author = $name_author;
    }

    function getAuthorAvatar() : int
    {
        return $this->avatar_author;
    }

    function setAuthorAvatar(int $avatar_author) : void
    {
        $this->avatar_author = $avatar_author;
    }

    function getTopicId() : int
    {
        return $this->id_topic;
    }

    function setTopicId(int $id_topic) : void
    {
        $this->id_topic = $id_topic;
    }

    function getTopicName() : string
    {
        return $this->name_topic;
    }

    function setTopicName(string $name_topic) : void
    {
        $this->name_topic = $name_topic;
    }

    function getTopicUrl() : ?string
    {
        return $this->url_topic;
    }

    function setTopicUrl(string $url_topic) : void
    {
        $this->url_topic = $url_topic;
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

    public function load($full = false)
    {
        $smt = $this->db->prepare(
            "SELECT
                m.content as content,
                m.is_reported as is_reported,
                m.is_deleted as is_deleted,
                m.id_author as id_author,
                a.nickname as name_author,
                a.avatar as avatar_author,
                m.id_topic as id_topic,
                t.name as name_topic,
                m.created_at as created_at,
                m.updated_at as updated_at
             FROM
                message AS m
             JOIN
                user AS a ON a.id = m.id_author
             JOIN
                topic AS t ON t.id = m.id_topic
             WHERE
                m.id = :id
        ");
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_INT);
        $smt->execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $this->setContent($row["content"]);
            $this->setIsReported($row["is_reported"]);
            $this->setIsDeleted($row["is_deleted"]);
            $this->setAuthorId($row["id_author"]);
            $this->setAuthorName($row["name_author"]);
            $this->setAuthorAvatar($row["avatar_author"]);
            $this->setTopicId($row["id_topic"]);
            $this->setTopicName($row["name_topic"]);
            $this->setCreatedAt($row["created_at"]);
            $this->setUpdatedAt($row["updated_at"]);

            if ($full == true)
            {
                $topic = new Topic();
                $topic->setId($this->getTopicId());
                $topic->load(true);
                $this->setTopicUrl($topic->getUrl());
            }
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

    /**
     * Création d'un nouveau message
     * 
     * @return bool
     */
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

    /**
     * Mis-à-jour d'un nouveau message
     * 
     * @return bool
     */
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
        $smt->bindValue(":id_author", $this->getAuthorId(), \PDO::PARAM_INT);
        $smt->bindValue(":id_topic", $this->getTopicId(), \PDO::PARAM_INT);
        if ($smt->execute())
        {
            return true;
        }
        return false;
    }

    /**
     * Retourner la position du message dans le topic. Utile pour la modération
     * 
     * @return int
     */
    public static function getPosition($id_topic, $id_msg) : ?int
    {
        $db = Connect::getPDO();
        $smt = $db->prepare(
            "SELECT
                COUNT(*) as pos
             FROM
                message
             WHERE
                id_topic = :id_topic
                AND
                id <= :id_msg
        ");
        $smt->bindValue("id_topic", $id_topic, \PDO::PARAM_INT);
        $smt->bindValue("id_msg", $id_msg, \PDO::PARAM_INT);
        if($smt->execute())
        {
            if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
            {
                return $row["pos"];
            }
        }
        return null;
    }

    /**
     * Recherche de tous les messages qui sont signalés et non désactivé
     * 
     * @return array
     */
    public static function getReport()
    {
        $db = Connect::getPDO();
        $smt = $db->prepare(
            "SELECT
                id,
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
                is_reported = TRUE 
                AND 
                is_deleted = FALSE
            "
        );
        $messages = [];
        if ($smt->execute())
        {
            $i = 0;
            while ($row = $smt->fetch(\PDO::FETCH_ASSOC))
            {
                $message = new Message();
                $message->setId($row["id"]);
                $message->setContent($row["content"]);
                $message->setIsReported($row["is_reported"]);
                $message->setIsDeleted($row["is_deleted"]);
                $message->setAuthorId($row["id_author"]);
                $message->setTopicId($row["id_topic"]);
                $message->setCreatedAt($row["created_at"]);
                $message->setUpdatedAt($row["updated_at"]);
                $messages[$i] = $message;
                $i++;
            }
            return $messages;
        }
        return null;
    }
}