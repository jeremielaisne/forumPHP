<?php

namespace App;

use App\Database\Connect;

include(__DIR__ . "/db/Connect.php");
/**
 * Création et gestion d'un utilisateur
 * 
 * @author Laisné Jérémie <laisne.jeremie83@gmail.com>
 */
class Forum extends Connect
{
    private $id;
    private $name;
    private $group;
    private $author;
    private $order;
    private $nbTopic;
    private $nbTopicModeration;
    private $isDeleted;
    private $created_at;
    private $updated_at;

    function __construct($id = null, $name = null, $group = null, $author = null, $order = null, $nbTopic = null, $nbTopicModeration = null, $isDeleted = null, $created_at = null, $updated_at = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->group = $group;
        $this->author = $author;
        $this->order = $order;
        $this->nbTopic = $nbTopic;
        $this->nbTopicModeration = $nbTopicModeration;
        $this->isDeleted = $isDeleted;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * Getters et Setters
     */
    function getId() : string
    {
        return $this->id;
    }

    function setId($id) : void
    {
        $this->id = $id;
    }

    function getName() : string
    {
        return $this->name;
    }

    function setName($name) : void
    {
        $this->name = $name;
    }

    function getGr() : string
    {
        return $this->group;
    }

    function setGr($group) : void
    {
        $this->group = $group;
    }

    function getAuthor() : string
    {
        return $this->author;
    }

    function setAuthor($author) : void
    {
        $this->author = $author;
    }

    function getOrder() : int
    {
        return $this->order;
    }

    function setOrder($order) : void
    {
        $this->order = $order;
    }

    function getNbTopic() : int
    {
        return $this->nbTopic;
    }

    function setNbTopic($nbTopic) : void
    {
        $this->nbTopic = $nbTopic;
    }

    function getNbTopicModeration() : int
    {
        return $this->nbTopicModeration;
    }

    function setNbTopicModeration($nbTopicModeration) : void
    {
        $this->nbTopicModeration = $nbTopicModeration;
    }

    function getIsDeleted() : bool
    {
        return $this->isDeleted;
    }

    function setIsDeleted($isDeleted) : void
    {
        $this->isDeleted = $isDeleted;
    }

    function getCreatedAt() : bool
    {
        return $this->created_at;
    }

    function setCreatedAt($created_at) : void
    {
        $this->created_at = $created_at;
    }

    function getUpdatedAt() : bool
    {
        return $this->updated_at;
    }

    function setUpdatedAt($updated_at): void
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
        $db = Connect::getPDO();
        $smt = $db->prepare(
            "SELECT 
                name,
                group,
                author,
                order,
                nbTopic,
                nbTopicModeration,
                isDeleted,
                created_at
             FROM 
                Forum 
             WHERE 
                id = :id");
        $smt->bindParam("id", $this->id, \PDO::PARAM_INT);
        if ($row = $smt->fetch(\PDO::FETCH_ASSOC))
        {
            $forum = new Forum;
            $forum->setId($this->id);
            $forum->setAuthor($row["author"]);
            $forum->setOrder($row["order"]);
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
        $db = Connect::getPDO();
        $smt = $db->prepare("SELECT 1 FROM Forum WHERE id = :id");
        $smt->bindParam("id", $this->id, \PDO::PARAM_INT);
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
        $db = Connect::getPDO();
        $smt = $db->prepare(
            "INSERT INTO Forum(
                name,
                group,
                author,
                order,
                nbTopic,
                nbTopicModeration,
                isDeleted,
                created_at
            VALUES(
                :name,
                :group,
                :author,
                :order,
                :nbTopic,
                :nbTopicModeration,
                :isDeleted,
                NOW()
            )");
        $smt->bindParam("name", $this->name, \PDO::PARAM_STR);
        $smt->bindParam("group", $this->group, \PDO::PARAM_INT);
        $smt->bindParam("author", $this->author, \PDO::PARAM_STR);
        $smt->bindParam("order", $this->order, \PDO::PARAM_INT);
        $smt->bindParam("nbTopic", $this->nbTopic, \PDO::PARAM_INT);
        $smt->bindParam("nbTopicModeration", $this->nbTopicModeration, \PDO::PARAM_INT);
        $smt->bindParam("isDeleted", $this->isDeleted, \PDO::PARAM_BOOL);
        if($smt->execute())
        {
            $this->id = $db->lastInsertId();
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

    }

    /**
     * Mis à jour d'un forum
     * 
     */
    function update()
    {

    }
}