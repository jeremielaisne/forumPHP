<?php

namespace App;

use App\Database\Connect;
use Cocur\Slugify\Slugify;
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
    private $name_forum;
    private $id_author;
    private $name_author;
    private $avatar_author;
    private $id_last_author;
    private $name_last_author;
    private $avatar_last_author;
    private $created_at;
    private $updated_at;

    protected $db;

    function __construct($id = null, $name = null, $active = null, $nb_view = null, $nb_message = null, $nb_message_moderator = null, $is_pin = false, $is_locked = false, $is_deleted = null, $id_forum = null, $name_forum = null, $id_author = null, $name_author = null, $avatar_author = null, $id_last_author = null, $name_last_author = null, $avatar_last_author = null, $created_at = null, $updated_at = null)
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
        $this->name_forum = $name_forum;
        $this->id_author = $id_author;
        $this->name_author = $name_author;
        $this->avatar_author = $avatar_author;
        $this->id_last_author = $id_last_author;
        $this->name_last_author = $name_last_author;
        $this->avatar_last_author = $avatar_last_author; 
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

    function getForumId() : int
    {
        return $this->id_forum;
    }

    function setForumId(int $id_forum) : void
    {
        $this->id_forum = $id_forum;
    }

    function getForumName() : ?string
    {
        return $this->name_forum;
    }

    function setForumName(string $name_forum) : void
    {
        $this->name_forum = $name_forum;
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

    function getLastAuthorId() : ?int
    {
        return $this->id_last_author;
    }

    function setLastAuthorId(int $id_last_author) : void
    {
        $this->id_last_author = $id_last_author;
    }

    function getLastAuthorName() : ?string
    {
        return $this->name_author;
    }

    function setLastAuthorName(string $name_last_author) : void
    {
        $this->name_last_author = $name_last_author;
    }

    function getLastAuthorAvatar() : ?int
    {
        return $this->avatar_last_author;
    }

    function setLastAuthorAvatar(int $avatar_last_author) : void
    {
        $this->avatar_last_author = $avatar_last_author;
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
                t.id as id,
                t.name as name,
                t.active as active,
                t.nb_view as nb_view,
                t.nb_message as nb_message,
                t.nb_message_moderator as nb_message_moderator,
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
                forum AS f ON f.id = t.id_forum
             JOIN 
                user AS a1 ON a1.id = t.id_author
             JOIN 
                user AS a2 ON a2.id = t.id_last_author
             WHERE
                t.id = :id"
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
            $this->setForumId($row["id_forum"]);
            $this->setForumName($row["name_forum"]);
            $this->setAuthorId($row["id_author"]);
            $this->setAuthorName($row["name_author"]);
            $this->setAuthorAvatar($row["avatar_author"]);
            $this->setLastAuthorId($row["id_last_author"]);
            $this->setLastAuthorName($row["name_last_author"]);
            $this->setLastAuthorAvatar($row["avatar_last_author"]);
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

    /**
     * Création d'un nouveau topic
     * 
     * @return bool
     */
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
        $smt->bindValue(":id_forum", $this->getForumId(), \PDO::PARAM_INT);
        $smt->bindValue(":id_author", $this->getAuthorId(), \PDO::PARAM_INT);
        $smt->bindValue(":id_last_author", $this->getLastAuthorId(), \PDO::PARAM_INT);

        if ($smt->execute())
        {
            $this->setId((int)$this->db->lastInsertId());
            return true;
        }
        return false;
    }

    /**
     * Mis à jour d'un topic
     * 
     *  @return bool
     */
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
        $smt->bindValue("id_forum", $this->getForumId(), \PDO::PARAM_INT);
        $smt->bindValue("id_author", $this->getAuthorId(), \PDO::PARAM_INT);
        $smt->bindValue("id_last_author", $this->getLastAuthorId(), \PDO::PARAM_INT);

        if ($smt->execute())
        {
            return true;
        }
        return false;
    }

    /**
     * Affichage des messages présent dans un topic
     * 
     *  @return array
     */
    public static function getMessages($id_topic) : ?array
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
                m.id_topic = :id_topic
        ");
        $smt->bindValue(":id_topic", $id_topic, \PDO::PARAM_INT);
        $messages = [];
        if($smt->execute())
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
                $message->setAuthorName($row["name_author"]);
                $message->setAuthorAvatar($row["avatar_author"]);
                $message->setTopicId($row["id_topic"]);
                $message->setTopicName($row["name_topic"]);
                $message->setCreatedAt($row["created_at"]);
                $message->setUpdatedAt($row["updated_at"]);
                $messages[$i] = $message;
                $i++;
            }
            return $messages;
        }
        return null;
    }

    /**
     * Retourne le nombre de messages d'un topic
     * 
     * @return int 
     */
    public static function getNbMessages($id_topic) : int
    {
        $db = Connect::getPDO();
        $smt = $db->prepare("SELECT id FROM message WHERE id_topic = :id_topic");
        $smt->bindValue(":id_topic", $id_topic, \PDO::PARAM_STR);
        if ($smt->execute())
        {
            return $smt->rowCount();
        }
        return null;
    }

    /**
     * Affichage du premier message d'un topic
     * 
     *  @return new Message
     */
    public static function getFirstMessage($id_topic) : ?Message
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
                m.id_topic = :id_topic 
             ORDER BY 
                m.id ASC
             LIMIT 1
            ");
        $smt->bindValue(":id_topic", $id_topic, \PDO::PARAM_STR);
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
                return $message;
            }
        }
        return null;
    }

    /**
     * Affichage du dernier message d'un topic
     * 
     *  @return new Message
     */
    public static function getLastMessage($id_topic) : ?Message
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
                m.id_topic = :id_topic
             ORDER BY 
                m.id DESC
             LIMIT 1
            ");
        $smt->bindValue(":id_topic", $id_topic, \PDO::PARAM_STR);
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
                return $message;
            }
        }
        return null;
    }

    /**
     * Affichage de l'url du topic
     * 
     *  @return string
     */
    public static function getUrl($id, $name, $page = 1, $search = null) : string
    {
        $slugify = new Slugify();
        $slug_name = $slugify->slugify($name);
        if ($search == null)
        {
            return "forum/". $id. "/" . $slug_name . "/page-" . $page;
        }
        return "forum/". $id . "/" . $slug_name . "/page-" . $page . "?s=" . $search;
    }
}