<?php

use App\Forum;
use App\Topic;
use App\Message;
use App\User;

use PHPUnit\Framework\TestCase;

class ForumTest extends TestCase {

    protected $user;

    protected function setUp()
    {
        $this->user = new User();
        $this->user->setId(1);
        $this->user->load();

        return $this;    
    }

    /**
     * @test creation du forum
     */
    public function fixturesForum()
    {
        $forum = new Forum();
        $forum->setName("Forum 1");
        $forum->setActive(true);
        $forum->setAuthor($this->user->getId());
        $forum->setOrderc(0);

        $this->assertTrue($forum->create());
    }

    /**
     * @test creation du topic
     */
    public function fixturesTopic()
    {
        $this->markTestIncomplete("TODO");

        $topic = new Topic();
        $topic->setName("Topic 1");
        $topic->setNbView(15);
        $topic->setNbMessage(15);
        $topic->setNbMessageModerator(0);
        $topic->setIsPin(false);
        $topic->setIsLocked(false);
        $topic->setIsDeleted(false);
        $topic->setAuthor($this->user->getId());
        $topic->lastAuthor($this->user->getId());
        $forum = loadForum();
        $topic->setForum($forum);

        $this->assertTrue($topic->create());

        $topic2 = new Topic();
        $topic2->setName("Topic 2");
        $topic2->setNbView(12);
        $topic2->setNbMessage(16);
        $topic2->setNbMessageModerator(0);
        $topic2->setIsPin(false);
        $topic2->setIsLocked(false);
        $topic2->setIsDeleted(false);
        $topic2->setAuthor($this->user->getId());
        $topic2->lastAuthor($this->user->getId());
        $topic2->setForum($forum);

        $this->assertTrue($topic2->create());
    }

    /**
     * @test creation du message
     */
    public function fixturesMessage()
    {
        $this->markTestIncomplete("TODO");

        $message = new Message();
        $message->setContent("Ceci est un message");
        $message->setIsReported(false);
        $message->setIsDeleted(false);
        $message->setAuthor($this->user->getId());
        $topic = loadTopic();
        $message->setTopic($topic);

        $this->assertTrue($message->create());

        $message2 = new Message();
        $message2->setContent("Ceci est un message reporté");
        $message->setIsReported(true);
        $message->setIsDeleted(false);
        $message->setAuthor($this->user->getId());
        $message->setTopic($topic);

        $this->assertTrue($message2->create());

        $message3 = new Message();
        $message3->setContent("C'est le dernier message");
        $message->setIsReported(false);
        $message->setIsDeleted(false);
        $message->setAuthor($this->user->getId());
        $message->setTopic($topic);

        $this->assertTrue($message3->create());
    }

    ##########
    ## FORUM
    ##########

    private function makeForum()
    {
        return $this->getMockBuilder(Forum::class)->getMock();
    }

    private function loadForum()
    {
        $forum = $this->makeForum();
        $forum->setId(1);
        $forum->load();
        return $forum;
    }

    /**
     * @test si le forum existe
     */
    public function isExistForum()
    {
        $this->markTestIncomplete("TODO");
        
        $forum = $this->loadForum();
        return $this->assertTrue($forum->isExist());
    }

    /**
     * @test affichage des topics d'un forum
     */
    public function getTopicsForum()
    {
        $this->markTestIncomplete("TODO");

        $forum = loadForum();
        $id_forum = $forum->getId();
        $tableau_topic = Forum::getTopics($id_forum);
        $name_topic = $tableau_topic[0]->getName();
        $this->assertEquals("Topic 1", $name_topic);
    }

    /**
     * @test affichage du nombre de topics d'un forum
     */
    public function getNbTopicsForum()
    {
        $this->markTestIncomplete("TODO");

        $forum = loadForum();
        $id_forum = $forum->getId();
        $this->assertEquals(2, Forum::getnbTopics($id_forum));
    }

    /**
     * @test affichage de tous les forums
     */
    public function getAllForums()
    {
        $this->markTestIncomplete("TODO");

        $forums = Forum::getAll();
        $forum_1 = $forums[0];
        $id_forum_1 = $forum_1->getName();
        $this->assertEquals("Topic 1", $id_forum_1);
    }

    /**
     * @test affichage de toutes les personnes connectés
     */
    public function getAllConnected()
    {
        $this->markTestIncomplete("TODO");

        $connected_users = Forum::getAllConnected();
        $user_kickr = $connected_users[0];
        $this->assertEquals("KickR", $user_kickr->getName());
    }

    /**
     * @test affichage de l'url
     */
    public function getUrlForum()
    {
        $this->markTestIncomplete("TODO");

        $forum = loadForum();
        $forum_url = $forum->getUrl();
        $this->assertEquals("/forum-1", $forum_url);
    }

    ##########
    ## TOPIC
    ##########

    private function makeTopic()
    {
        $topic = $this->getMockBuilder(Topic::class)->getMock();
        $topic->method('setForum')->willReturn($this->loadForum());
        return $topic;
    }

    private function loadTopic()
    {
        $forum = $this->makeTopic();
        $forum->setId(1);
        $forum->load();
        return $forum;
    }

    /**
     * @test si le topic existe
     */
    public function isExistTopic()
    {
        $this->markTestIncomplete("TODO");

        $topic = $this->loadTopic();
        return $this->assertTrue($topic->isExist());
    }

    /**
     * @test affichage des messages d'un topic
     */
    public function getMessagesTopic()
    {
        $this->markTestIncomplete("TODO");

        $topic = loadTopic();
        $tableau_msg = $topic->getMessages();
        $message_content = $tableau_msg[0]->getContent();
        $this->assertEquals("Ceci est un message", $message_content);
    }

    /**
     * @test affichage du nombre de topics d'un forum
     */
    public function getNbMessagesTopic()
    {
        $this->markTestIncomplete("TODO");

        $topic = loadTopic();
        $this->assertEquals(3, $topic->getnbMessages());
    }

    /**
     * @test affichage du premier message d'un topic
     */
    public function getFirstMessageTopic()
    {
        $this->markTestIncomplete("TODO");

        $topic = loadTopic();
        $msg = $topic->getFirstMessages();
        $this->assertEquals("Ceci est un message", $msg->getContent());
    }

    /**
     * @test affichage du dernier message d'un topic
     */
    public function getLastMessageTopic()
    {
        $this->markTestIncomplete("TODO");

        $topic = loadTopic();
        $msg = $topic->getLastMessages();
        $this->assertEquals("C'est le dernier message", $msg->getContent());
    }

    /**
     * @test affichage de l'url
     */
    public function getUrlTopic()
    {
        $this->markTestIncomplete("TODO");

        $topic = loadTopic();
        $topic_url = $topic->getUrl();
        $this->assertEquals("/forum-1/topic-1", $topic_url);
    }

    ############
    ## MESSAGES
    ############
    
    private function makeMessage()
    {
        $message = $this->getMockBuilder(Message::class)->getMock();
        $message->method('setTopic')->willReturn($this->loadTopic());
        return $message;
    }

    private function loadMessage()
    {
        $message = $this->makeMessage();
        $message->setId(1);
        $message->load();
        return $message;
    }

    /**
     * @test si le message existe
     */
    public function isExistMessage()
    {
        $this->markTestIncomplete("TODO");

        $message = $this->loadMessage();
        $this->assertTrue($message->isExist());
    }

    /**
     * @test position du message dans le topic
     */
    public function getPositionInTopic()
    {
        $this->markTestIncomplete("TODO");

        $message = $this->loadMessage();
        $position = $message->getPositionInTopic();
        $this->assertEquals(1, $position);
    }

    /**
     * @test recherche de tous les messages signalés et non supprimés
     */
    public function getReport()
    {
        $this->markTestIncomplete("TODO");

        $report_messages = Message::getReport();
        $this->assertEquals("Ceci est un message reporté", $report_messages[0]->getContent());
    }
}