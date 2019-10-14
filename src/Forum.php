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

    /*** Méthodes */

    /**
     * Initialisation et affectation des variables
     * 
     * @return obj new Forum
     */
    function load() : Forum
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
                created_at,
                updated_at
             FROM 
                Forum 
             WHERE 
                id = :id");
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_INT);
        $smt->execute();
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $this->setName($row["name"]);
            $this->setAuthor($row["id_author"]);
            $this->setActive($row["active"]);
            $this->setorderc($row["orderc"]);
            $this->setNbTopic($row["nbTopic"]);
            $this->setNbTopicModeration($row["nbTopicModeration"]);
            $this->setIsDeleted($row["isDeleted"]);
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
        $smt->bindValue(":name", $this->getName(), \PDO::PARAM_STR);
        $smt->bindValue(":active", $this->getActive(), \PDO::PARAM_BOOL);
        $smt->bindValue(":id_author", $this->getAuthor(), \PDO::PARAM_INT);
        $smt->bindValue(":orderc", $this->getOrderc(), \PDO::PARAM_INT);
        $smt->bindValue(":nbTopic", $this->getNbTopic(), \PDO::PARAM_INT);
        $smt->bindValue(":nbTopicModeration", $this->getNbTopicModeration(), \PDO::PARAM_INT);
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
                active = :active,
                id_author = :id_author,
                orderc = :orderc,
                nbTopic = :nbTopic,
                nbTopicModeration = :nbTopicModeration,
                isDeleted = :isDeleted,
                updated_at = NOW()
            WHERE
                id = :id
        ");
        $smt->bindValue(":id", $this->getId(), \PDO::PARAM_INT);
        $smt->bindValue(":name", $this->getName(), \PDO::PARAM_STR);
        $smt->bindValue(":active", $this->getActive(), \PDO::PARAM_BOOL);
        $smt->bindValue(":id_author", $this->getAuthor(), \PDO::PARAM_STR);
        $smt->bindValue(":orderc", $this->getOrderc(), \PDO::PARAM_INT);
        $smt->bindValue(":nbTopic", $this->getNbTopic(), \PDO::PARAM_INT);
        $smt->bindValue(":nbTopicModeration", $this->getNbTopicModeration(), \PDO::PARAM_INT);
        $smt->bindValue(":isDeleted", $this->getIsDeleted(), \PDO::PARAM_BOOL);
        if ($smt->execute())
        {
            return true;
        }
        return false;
    }

    /**
     * Tableau de topics présents dans le forum 
     * 
     *  @return array
     */
    public static function getTopics($id_forum) : array
    {
        $db = Connect::getPDO();
        $smt = $db->prepare(
            "SELECT
                id,
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
                id_forum = :id_forum"
        );
        $smt->bindValue(":id_forum", $id_forum, \PDO::PARAM_INT);
        $smt->execute();
        $topics = [];
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $topic = new Topic();
            $topic->setId($row["id"]);
            $topic->setName($row["name"]);
            $topic->setActive($row["active"]);
            $topic->setNbView($row["nb_view"]);
            $topic->setNbMessage($row["nb_view"]);
            $topic->setNbMessageModerator($row["nb_view"]);
            $topic->setIsPin($row["is_pin"]);
            $topic->setIsLocked($row["is_locked"]);
            $topic->setIsDeleted($row["is_deleted"]);
            $topic->setForum($row["id_forum"]);
            $topic->setAuthor($row["id_author"]);
            $topic->setLastAuthor($row["id_last_author"]);
            $topic->setCreatedAt($row["created_at"]);
            $topic->setUpdatedAt($row["updated_at"]);
            $topics[$topic->getId()] = $topic;
        }
        return $topics;
    }

    /**
     * Nombre de topics presents dans le forum
     * 
     *  @return int
     */
    public static function getNbTopics($id_forum) : ?int
    {
        $db = Connect::getPDO();
        $smt = $db->prepare("SELECT id FROM topic WHERE id_forum = :id_forum");
        $smt->bindValue(":id_forum", $id_forum, \PDO::FETCH_ASSOC);
        if($smt->execute())
        {
            return $smt->rowCount();
        }
        return null;
    }

    /**
     * Affichage d'un tableau de tous les forums existant
     * 
     *  @return array
     */
    public static function getAll() : array
    {
        $db = Connect::getPDO();
        $smt = $db->prepare(
            "SELECT
                id,
                name,
                active,
                id_author,
                orderc,
                nbTopic,
                nbTopicModeration,
                isDeleted,
                created_at,
                updated_at 
            FROM 
                forum");
        $smt->execute();
        $forums = [];
        if($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $forum = new Forum();
            $forum->setId($row["id"]);
            $forum->setName($row["name"]);
            $forum->setActive($row["active"]);
            $forum->setAuthor($row["id_author"]);
            $forum->setOrderc($row["orderc"]);
            $forum->setNbTopic($row["nbTopic"]);
            $forum->setNbTopicModeration($row["nbTopicModeration"]);
            $forum->setIsDeleted($row["isDeleted"]);
            $forum->setCreatedAt($row["created_at"]);
            $forum->setUpdatedAt($row["updated_at"]);
            $forums[$forum->getId()] = $forum; 
        }
        return $forums;
    }

    /**
     * Affichage de l'url du forum
     * 
     *  @return string
     */
    public static function getUrl($id, $page = 1, $search = null) : string
    {
        if ($search == null)
        {
            return "forum/". $id. "/page-" . $page;
        }
        return "forum/". $id . "/page-" . $page . "?s=" . $search;
    }
}