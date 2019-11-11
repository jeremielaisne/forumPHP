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
    private $description;
    private $active;
    private $id_author;
    private $name_author;
    private $avatar_author;
    private $orderc;
    private $isDeleted;
    private $created_at;
    private $updated_at;

    private $url;
    private $nbTopics;
    private $nbTopicsModerator;
    private $nbMessages;

    protected $db;

    function __construct(int $id = null, string $name = null, string $description = null, bool $active = null, int $id_author = null, string $name_author = null, string $avatar_author = null, int $orderc = null, bool $isDeleted = false, datetime $created_at = null, datetime $updated_at = null, string $url = null, int $nbTopics = 0, int $nbTopicsModerator = 0, int $nbMessages = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->active = $active;
        $this->id_author = $id_author;
        $this->name_author = $name_author;
        $this->avatar_author = $avatar_author;
        $this->orderc = $orderc;
        $this->isDeleted = $isDeleted;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;

        $this->url = $url;
        $this->nbTopics = $nbTopics;
        $this->nbTopicModerator = $nbTopicsModerator;
        $this->nbMessages = $nbMessages;

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

    function getDescription() : string
    {
        return $this->description;
    }

    function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    function getActive() : bool
    {
        return $this->active;
    }

    function setActive(bool $active) : void
    {
        $this->active = $active;
    }

    function getAuthorId() : ?int
    {
        return $this->id_author;
    }

    function setAuthorId(int $id_author) : void
    {
        $this->id_author = $id_author;
    }

    function getAuthorName() : ?string
    {
        return $this->name_author;
    }

    function setAuthorName(string $name_author) : void
    {
        $this->name_author = $name_author;
    }

    function getAuthorAvatar() : ?int
    {
        return $this->avatar_author;
    }

    function setAuthorAvatar(int $avatar_author) : void
    {
        $this->avatar_author = $avatar_author;
    }

    function getOrderc() : int
    {
        return $this->orderc;
    }

    function setOrderc(int $orderc) : void
    {
        $this->orderc = $orderc;
    }

    function getIsDeleted() : bool
    {
        return $this->isDeleted;
    }

    function setIsDeleted(bool $isDeleted) : void
    {
        $this->isDeleted = $isDeleted;
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

    /*** Méthodes */

    /**
     * Initialisation et affectation des variables
     * 
     * @return obj new Forum
     */
    function load($full = false) : Forum
    {
        $smt = $this->db->prepare(
            "SELECT 
                f.name AS name,
                f.active AS active,
                f.description AS description,
                f.id_author AS id_author,
                a.nickname AS name_author,
                a.avatar AS avatar_author,
                f.orderc AS orderc,
                f.isDeleted AS isDeleted,
                f.created_at AS created_at,
                f.updated_at AS updated_at
             FROM 
                forum AS f
             JOIN
                user AS a ON a.id = f.id_author
             WHERE 
                f.id = :id");
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_INT);
        $smt->execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $this->setName($row["name"]);
            $this->setDescription($row["description"]);
            $this->setAuthorId($row["id_author"]);
            $this->setAuthorName($row["name_author"]);
            $this->setAuthorAvatar($row["avatar_author"]);
            $this->setActive($row["active"]);
            $this->setOrderc($row["orderc"]);
            $this->setIsDeleted($row["isDeleted"]);
            $this->setCreatedAt($row["created_at"]);
            $this->setUpdatedAt($row["updated_at"]);

            if ($full == true)
            {
                $this->setNbTopics();
                $this->setNbTopicsModerator();
                $this->setNbMessages();
                $pages = ceil($this->getNbTopics()/15);
                $pages == 0 ? $pages = 1 : $pages; 
                $this->setUrl($pages);
            }
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
        $smt = $this->db->prepare("SELECT 1 FROM forum WHERE id = :id");
        $smt->bindValue("id", $this->getId(), \PDO::PARAM_INT);
        $smt->execute();
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
    function create() : bool
    {
        $smt = $this->db->prepare(
            "INSERT INTO forum(
                name,
                description,
                active,
                id_author,
                orderc,
                isDeleted,
                created_at
            )VALUES(
                :name,
                :description,
                :active,
                :id_author,
                :orderc,
                :isDeleted,
                NOW()
            )");
        $smt->bindValue(":name", $this->getName(), \PDO::PARAM_STR);
        $smt->bindValue(":description", $this->getDescription(), \PDO::PARAM_STR);
        $smt->bindValue(":active", $this->getActive(), \PDO::PARAM_BOOL);
        $smt->bindValue(":id_author", $this->getAuthorId(), \PDO::PARAM_INT);
        $smt->bindValue(":orderc", $this->getOrderc(), \PDO::PARAM_INT);
        $smt->bindValue(":isDeleted", $this->getIsDeleted(), \PDO::PARAM_BOOL);
        if($smt->execute())
        {
            $this->setId((int)$this->db->lastInsertId());
            return true;
        }
        return false;
    }

    /**
     * Suppression d'un forum
     * 
     * @return bool
     */
    function delete() : bool
    {
        $smt = $this->db->prepare("DELETE FROM forum WHERE id = :id");
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_INT);
        if($smt->execute())
        {
            return true;
        }
        return false;
    }

    /**
     * Mis à jour d'un forum
     * 
     *  @return bool
     */
    function update() : bool
    {
        $smt = $this->db->prepare(
            "UPDATE 
                forum 
            SET 
                name = :name,
                description = :description,
                active = :active,
                id_author = :id_author,
                orderc = :orderc,
                isDeleted = :isDeleted,
                updated_at = NOW()
            WHERE
                id = :id
        ");
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_INT);
        $smt->bindValue(":name", $this->getName(), \PDO::PARAM_STR);
        $smt->bindValue(":description", $this->getDescription(), \PDO::PARAM_STR);
        $smt->bindValue(":active", $this->getActive(), \PDO::PARAM_BOOL);
        $smt->bindValue(":id_author", $this->getAuthorId(), \PDO::PARAM_STR);
        $smt->bindValue(":orderc", $this->getOrderc(), \PDO::PARAM_INT);
        $smt->bindValue(":isDeleted", $this->getIsDeleted(), \PDO::PARAM_BOOL);
        if ($smt->execute())
        {
            return true;
        }
        return false;
    }

    /**
     * Setter url d'un forum
     * 
     */
    public function setUrl($page = 1, $search = null) : void
    {
        if ($search == null)
        {
            $this->url = "forum/". $this->id. "/page-" . $page;
        }
        else
        {
            $this->url = "forum/". $this->id . "/page-" . $page . "?s=" . $search;
        }
    }

    /**
     * Getter url d'un forum
     * 
     *  @return string
     */
    public function getUrl() : ?string
    {
        return $this->url;
    }

    /**
     * Nombre de topics presents dans le forum 
     */
    public function setNbTopics() : void
    {
        $smt = $this->db->prepare("SELECT id FROM topic WHERE id_forum = :id_forum");
        $smt->bindValue(":id_forum", $this->getId(), \PDO::PARAM_INT);
        if($smt->execute())
        {
            $this->nbTopics = $smt->rowCount();
        }
    }

    /**
     * Getter nbTopics d'un forum
     * 
     *  @return int
     */
    public function getNbTopics() : ?int
    {
        return $this->nbTopics;
    }

    /**
     * Nombre de topics presents dans le forum 
     */
    public function setNbTopicsModerator() : void
    {
        $smt = $this->db->prepare("SELECT id FROM topic WHERE id_forum = :id_forum AND is_deleted = true");
        $smt->bindValue(":id_forum", $this->getId(), \PDO::PARAM_INT);
        if($smt->execute())
        {
            $this->nbTopicsModerator = $smt->rowCount();
        }
    }

    /**
     * Getter nbTopics en Moderator d'un forum
     * 
     *  @return int
     */
    public function getNbTopicsModerator() : ?int
    {
        return $this->nbTopicsModerator;
    }

    /**
     * Nombre de messages presents dans le forum
     */
    public function setNbMessages() : void
    {
        $smt = $this->db->prepare("SELECT m.id FROM message AS m JOIN topic as t ON t.id = m.id_topic WHERE t.id_forum = :id_forum");
        $smt->bindValue(":id_forum", $this->getId(), \PDO::PARAM_INT);
        if ($smt->execute())
        {
            $this->nbMessages = $smt->rowCount();
        }
    }

    /**
     * Getter nbTopics d'un forum
     * 
     *  @return int
     */
    public function getNbMessages() : ?int
    {
        return $this->nbMessages;
    }

    /**
     * Tableau de topics présents dans le forum 
     * 
     *  @return array
     */
    public static function getTopics($id_forum, $full = false, $deb = 0, $fin = 9) : array
    {
        $db = Connect::getPDO();
        $smt = $db->prepare(
            "SELECT
                t.id as id,
                t.name as name,
                t.active as active,
                t.nb_view as nb_view,
                t.is_pin as is_pin,
                t.is_locked as is_locked,
                t.is_deleted as is_deleted,
                t.id_forum as id_forum,
                f.name as name_forum,
                t.id_author as id_author,
                a1.nickname as name_author,
                a1.avatar as avatar_author,
                t.id_last_author as id_last_author,
                a2.nickname as name_last_author,
                a2.avatar as avatar_last_author,
                t.created_at as created_at,
                t.updated_at as updated_at
            FROM
                topic AS t
            JOIN
                forum as f ON f.id = t.id_forum
            JOIN 
                user AS a1 ON a1.id = t.id_author
            JOIN 
                user AS a2 ON a2.id = t.id_last_author
            WHERE
                t.id_forum = :id_forum
            LIMIT $deb, $fin"
        );
        $smt->bindValue(":id_forum", $id_forum, \PDO::PARAM_INT);
        $smt->execute();
        $topics = [];
        $i = 0;
        while ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $topic = new Topic();
            $topic->setId($row["id"]);
            $topic->setName($row["name"]);
            $topic->setActive($row["active"]);
            $topic->setNbView($row["nb_view"]);
            $topic->setIsPin($row["is_pin"]);
            $topic->setIsLocked($row["is_locked"]);
            $topic->setIsDeleted($row["is_deleted"]);
            $topic->setForumId($row["id_forum"]);
            $topic->setForumName($row["name_forum"]);
            $topic->setAuthorId($row["id_author"]);
            $topic->setAuthorName($row["name_author"]);
            $topic->setAuthorAvatar($row["avatar_author"]);
            $topic->setLastAuthorId($row["id_last_author"]);
            $topic->setLastAuthorName($row["name_last_author"]);
            $topic->setLastAuthorAvatar($row["avatar_last_author"]);
            $topic->setCreatedAt($row["created_at"]);
            $topic->setUpdatedAt($row["updated_at"]);

            if ($full == true)
            {
                $topic->setNbMessages();
                $topic->setNbMessagesModerator();
                $pages = ceil($topic->getNbMessages()/15);
                $pages == 0 ? $pages = 1 : $pages; 
                $topic->setUrl($topic->getName(), $pages);
            }

            $topics[$i] = $topic;
            $i++;
        }
        return $topics;
    }

    /**
     * Affichage du dernier message d'un forum
     * 
     *  @return new Message
     */
    public static function getLastMessage($id_forum, $full = false) : ?Message
    {
        $db = Connect::getPDO();
        $smt = $db->prepare(
            "SELECT
                m.id as id,
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
                t.id_forum = :id_forum 
            ORDER BY
                m.id DESC
            LIMIT 1
            ");
        $smt->bindValue(":id_forum", $id_forum, \PDO::PARAM_STR);
        if ($smt->execute())
        {
            if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
            {
                $message = new Message();
                $message->setId($row["id"]);
                $message->setContent($row["content"]);
                $message->setIsReported($row["is_reported"]);
                $message->setIsDeleted($row["is_deleted"]);
                $message->setAuthorId($row["id_author"]);
                $message->setAuthorName($row["name_author"]);
                $message->setAuthorAvatar($row["avatar_author"]);
                $message->setTopicId($row["id_topic"]);
                $message->setTopicName($row["name_topic"]);
                $message->setCreatedAt($row["created_at"]);
                $message->setUpdatedAt($row["updated_at"]);

                if ($full == true)
                {
                    $topic = new Topic();
                    $topic->setId($message->getTopicId());
                    $topic->load(true);
                    $message->setTopicUrl($topic->getUrl());
                }

                return $message;
            }
        }
        return null;
    }

    /**
     * Affichage d'un tableau de tous les forums existant
     * 
     *  @return array
     */
    public static function getAll($full = false) : array
    {
        $db = Connect::getPDO();
        $smt = $db->prepare(
            "SELECT
                f.id as id,
                f.name AS name,
                f.description AS description,
                f.active AS active,
                f.id_author AS id_author,
                a.nickname as name_author,
                a.avatar as avatar_author,
                f.orderc AS orderc,
                f.isDeleted AS isDeleted,
                f.created_at AS created_at,
                f.updated_at AS updated_at
            FROM 
                forum AS f
            JOIN
                user AS a ON a.id = f.id_author");
        $smt->execute();
        $forums = [];
        $i = 0;
        while ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $forum = new Forum();
            $forum->setId($row["id"]);
            $forum->setDescription($row["description"]);
            $forum->setName($row["name"]);
            $forum->setAuthorId($row["id_author"]);
            $forum->setAuthorName($row["name_author"]);
            $forum->setAuthorAvatar($row["avatar_author"]);
            $forum->setActive($row["active"]);
            $forum->setorderc($row["orderc"]);
            $forum->setIsDeleted($row["isDeleted"]);
            $forum->setCreatedAt($row["created_at"]);
            $forum->setUpdatedAt($row["updated_at"]);

            if ($full == true)
            {
                $forum->setNbTopics();
                $forum->setNbTopicsModerator();
                $forum->setNbMessages();
                $pages = ceil($forum->getNbTopics()/15);
                $pages == 0 ? $pages = 1 : $pages; 
                $forum->setUrl($pages);
            }

            $forums[$i] = $forum; 
            $i++;
        }
        return $forums;
    }
}