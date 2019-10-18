<?php

use App\Forum;
use App\Topic;
use App\Message;
use App\User;

use PHPUnit\Framework\TestCase;

class ForumTest extends TestCase {

    protected $user;
    protected $forum;
    protected $topic;
    protected $message;

    protected function setUp()
    {
        $this->user = new User();
        $this->user->setId(1);
        $this->user->load();

        $this->forum = new Forum();
        $this->topic = new Topic();
        $this->message = new Message();

        return $this;    
    }

    ##########
    ## FORUM
    ##########

    private function getForum()
    {
        return $this->forum;
    }

    private function setForum($nb)
    {
        return $this->forum->setId($nb);
    }

    private function loadWithArgumentForum()
    {
        $loadforum = $this->forum->load();
        $this->assertInstanceOf(Forum::class, $loadforum);
        $this->setForum(1);
        $loadforum = $this->forum->load();
        $this->assertIsString($loadforum->getName());
    }

    private function isExistTrueForum()
    {
        $this->assertTrue($this->forum->isExist());
    }
    
    private function fixturesForum()
    {
        $forum = new Forum();
        $forum->setName("Forum 1");
        $forum->setActive(true);
        $forum->setAuthor($this->user->getId());
        $forum->setOrderc(0);

        $this->assertTrue($forum->create());
    }

    private function updateForum()
    {
        $this->setForum(1);
        $forum = $this->getForum()->load();
        $forum->setOrderc(1);
        $this->assertTrue($forum->update());
    }

    /**
     * @test creation du forum
     */
    public function makeForum()
    {
        $this->setForum(1);
        $this->getForum()->load();
        
        if (!$this->getForum()->isExist())
        {
            $this->fixturesForum();
        }
        else
        {
            $this->loadWithArgumentForum();
            $this->isExistTrueForum();
            $this->updateForum();
        }
    }

    /**
     * @test affichage des topics d'un forum
     */
    public function getTopicsForum()
    {
        $this->setForum(1);
        $forum = $this->getForum()->load();
        $topics = Forum::getTopics($forum->getId());
        $name_topic = $topics[0]->getName();
        $this->assertEquals("Topic 1", $name_topic);
    }

    /**
     * @test affichage du nombre de topics d'un forum
     */
    public function getNbTopicsForum()
    {
        $this->setForum(1);
        $forum = $this->getForum()->load();
        $this->assertEquals(2, Forum::getNbTopics($forum->getId()));
    }

    /**
     * @test affichage de tous les forums
     */
    public function getAllForums()
    {
        $forums = Forum::getAll();
        $forum_1 = $forums[0];
        $forum_1_name = $forum_1->getName();
        $forum_1_author_name = $forum_1->getAuthorName();
        $this->assertEquals("Forum 1", $forum_1_name);
        $this->assertEquals("KickR", $forum_1_author_name);
    }

    /**
     * @test affichage de l'url
     */
    public function getUrlForum()
    {
        $this->setForum(1);
        $forum = $this->getForum()->load();
        $forum_url = Forum::getUrl($forum->getId());
        $this->assertEquals("forum/1/page-1", $forum_url);
    }

    ##########
    ## TOPIC
    ##########

    private function getTopic()
    {
        return $this->topic;
    }

    private function setTopic($nb)
    {
        $this->topic->setId($nb);
    }

    private function loadWithArgumentTopic()
    {
        $loadtopic = $this->topic->load();
        $this->assertInstanceOf(Topic::class, $loadtopic);
        $this->setTopic(1);
        $loadtopic = $this->topic->load();
        $this->assertIsString($loadtopic->getName());
        $topic_author_name = $loadtopic->getAuthorName();
        $this->assertEquals("KickR", $topic_author_name);
    }

    private function isExistTrueTopic()
    {
        $this->assertTrue($this->topic->isExist());
    }

    private function fixturesTopics()
    {
        $this->setForum(1);
        $this->getForum()->load();

        $topic = new Topic();
        $topic->setName("Topic 1");
        $topic->setActive(true);
        $topic->setNbView(15);
        $topic->setNbMessage(15);
        $topic->setNbMessageModerator(0);
        $topic->setIsPin(false);
        $topic->setIsLocked(false);
        $topic->setIsDeleted(false);
        $topic->setAuthor($this->user->getId());
        $topic->setlastAuthor($this->user->getId());
        $topic->setForum($this->getForum()->getId());

        $this->assertTrue($topic->create());

        $topic2 = new Topic();
        $topic2->setName("Topic 2");
        $topic2->setActive(true);
        $topic2->setNbView(12);
        $topic2->setNbMessage(16);
        $topic2->setNbMessageModerator(0);
        $topic2->setIsPin(false);
        $topic2->setIsLocked(false);
        $topic2->setIsDeleted(false);
        $topic2->setAuthor($this->user->getId());
        $topic2->setlastAuthor($this->user->getId());
        $topic2->setForum($this->getForum()->getId());

        $this->assertTrue($topic2->create());
    }

    private function updateTopic()
    {
        $this->setTopic(1);
        $topic = $this->getTopic()->load();
        $topic->setActive(False);
        $this->assertTrue($topic->update());
    }

    /**
     * @test creation du topic
     */
    public function makeTopic()
    {
        $this->setTopic(1);
        $this->getTopic()->load();
        
        if (!$this->getTopic()->isExist())
        {
            $this->fixturesTopics();
        }
        else
        {
            $this->loadWithArgumentTopic();
            $this->isExistTrueTopic();
            $this->updateTopic();
        }
    }

    /**
     * @test affichage des messages d'un topic
     */
    public function getMessagesTopic()
    {
        $this->setTopic(1);
        $topic = $this->getTopic()->load();
        $messages = Topic::getMessages($topic->getId());
        $message_content = $messages[0]->getContent();
        $this->assertEquals("Ceci est un message", $message_content);
    }

    /**
     * @test affichage du nombre de topics d'un forum
     */
    public function getNbMessagesTopic()
    {
        $this->setTopic(1);
        $topic = $this->getTopic()->load();
        $this->assertEquals(2, Topic::getnbMessages($topic->getId()));
        $this->setTopic(2);
        $topic = $this->getTopic()->load();
        $this->assertEquals(1, Topic::getnbMessages($topic->getId()));
    }

    /**
     * @test affichage du premier message d'un topic
     */
    public function getFirstMessageTopic()
    {
        $this->setTopic(1);
        $topic = $this->getTopic()->load();
        $msg = Topic::getFirstMessage($topic->getId());
        $this->assertEquals("Ceci est un message", $msg->getContent());
    }

    /**
     * @test affichage du dernier message d'un topic
     */
    public function getLastMessageTopic()
    {
        $this->setTopic(1);
        $topic = $this->getTopic()->load();
        $msg = Topic::getLastMessage($topic->getId());
        $this->assertEquals("C'est le dernier message", $msg->getContent());
    }

    /**
     * @test affichage de l'url
     */
    public function getUrlTopic()
    {
        $this->setTopic(1);
        $topic = $this->getTopic()->load();
        $topics_url = Topic::getUrl($topic->getId(), $topic->getName());
        $this->assertEquals("forum/1/topic-1/page-1", $topics_url);
    }

    ############
    ## MESSAGES
    ############
    
    private function getMessage()
    {
        return $this->message;
    }

    private function setMessage($nb)
    {
        $this->message->setId($nb);
    }

    private function loadWithArgumentMessage()
    {
        $loadmessage = $this->message->load();
        $this->assertInstanceOf(Message::class, $loadmessage);
        $this->setMessage(1);
        $loadmessage = $this->message->load();
        $this->assertIsString($loadmessage->getContent());
    }

    private function isExistTrueMessage()
    {
        $this->assertTrue($this->message->isExist());
    }

    private function fixturesMessages()
    {
        $this->setTopic(1);
        $this->getTopic()->load();

        $message = new Message();
        $message->setContent("Ceci est un message");
        $message->setIsReported(false);
        $message->setIsDeleted(false);
        $message->setAuthor($this->user->getId());
        $message->setTopic($this->getTopic()->getId());

        $this->assertTrue($message->create());

        $this->setTopic(2);
        $this->getTopic()->load();

        $message2 = new Message();
        $message2->setContent("Ceci est un message reporté");
        $message2->setIsReported(true);
        $message2->setIsDeleted(false);
        $message2->setAuthor($this->user->getId());
        $message2->setTopic($this->getTopic()->getId());

        $this->assertTrue($message2->create());

        $this->setTopic(1);
        $this->getTopic()->load();

        $message3 = new Message();
        $message3->setContent("C'est le dernier message");
        $message3->setIsReported(false);
        $message3->setIsDeleted(false);
        $message3->setAuthor($this->user->getId());
        $message3->setTopic($this->getTopic()->getId());

        $this->assertTrue($message3->create());
    }

    private function updateMessage()
    {
        $this->setMessage(2);
        $message = $this->getMessage()->load();
        $message->setContent("message reporté modifié...");
        $this->assertTrue($message->update());
    }

    /**
     * @test creation d un message
     */
    public function makeMessage()
    {
        $this->setMessage(1);
        $this->getMessage()->load();
        
        if (!$this->getMessage()->isExist())
        {
            $this->fixturesMessages();
        }
        else
        {
            $this->loadWithArgumentMessage();
            $this->isExistTrueMessage();
            $this->updateMessage();
        }
    }

    /**
     * @test position du message dans le topic
     */
    public function getPositionInTopic()
    {
        $this->setTopic(1);
        $topic = $this->getTopic()->load();
        $this->setMessage(3);
        $message = $this->getMessage()->load();
        $position = Message::getPosition($topic->getId(), $message->getId());
        $this->assertEquals(2, $position);
    }

    /**
     * @test recherche de tous les messages signalés et non supprimés
     */
    public function getReportInTopic()
    {
        $report_messages = Message::getReport();
        $this->assertEquals("message reporté modifié...", $report_messages[0]->getContent());
    }
}