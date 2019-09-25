<?php

use PHPUnit\Framework\TestCase;
use App\User;

class UserTest extends TestCase 
{
    protected $user;

    public function setUp()
    {
        if (null == $this->user)
        {
            $this->user = new User();
        }
    }

    public function testSetterId()
    {
        $this->user->setId(1);
        $this->assertSame(1, $this->user->getId(1));
    }

    public function testLoad()
    {
        self::testSetterId();
        $this->assertIsObject($this->user->load());
        $this->assertEquals('Laisné', $this->user->getLastname());
        $this->assertEquals('Jérémie', $this->user->getFirstname());
    }
}