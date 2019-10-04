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

    /**
     * @test
     */
    public function testSetterId()
    {
        $this->user->setId(1);
        $this->assertSame(1, $this->user->getId());
    }

    /**
     * @test
     */
    public function testLoad()
    {
        $this->user->setId(1);
        $this->assertIsObject($this->user->load());
        $this->assertEquals('Laisné', $this->user->getLastname());
        $this->assertEquals('Jérémie', $this->user->getFirstname());
    }

    /**
     * @test
     */
    public function testIsExist()
    {
        $new_user = new User();
        $new_user->setId(1);
        $new_user->load();
        $this->assertTrue($new_user->isExist());
    }

    /**
     * @test
     */
    public function testVerifyUniqueNickname()
    {
        $new_user = new User();
        $new_user->setId(2);
        $new_user->setNickname("KickR");
        $this->assertFalse(User::verifyUniqueNickname($new_user->getNickname()));
        $new_user->setNickname("zhfezhoiezhf");
        $this->assertTrue(User::verifyUniqueNickname($new_user->getNickname()));
    }

    /**
     * @test
     */
    public function testVerifyUniqueEmail()
    {
        $new_user = new User();
        $new_user->setId(2);
        $new_user->setEmail("jlai083@live.fr");
        $this->assertFalse(User::verifyUniqueEmail($new_user->getEmail()));
        $new_user->setEmail("truc083@live.fr");
        $this->assertTrue(User::verifyUniqueEmail($new_user->getEmail()));
    }

    /**
     * @test
     */
    public function testVerifyUniquePassword()
    {
        $new_user = new User();
        $new_user->setId(2);
        $new_user->setMdp(sha1('test'));
        $this->assertFalse(User::verifyUniquePassword($new_user->getMdp()));
        $new_user->setMdp(sha1("truc"));
        $this->assertTrue(User::verifyUniquePassword($new_user->getMdp()));
    }

    /**
     * @test
     */
    public function testGeneratePasswordWithoutMail()
    {
        $stub = $this->getMockBuilder(User::class)
                     ->disableOriginalClone()
                     ->getMock();
        $stub->method('generateMail')
             ->will($this->returnValue(false));

        $this->assertIsString(User::generatePassword());
        $this->assertContains("ERROR_MAIL_",User::generatePassword());
    }

    /**
     * @test
     */
    public function testEmailing()
    {
        $this->markTestIncomplete("Email->send() desactive pour l'instant.. Parametre mailer fonctionne pas");
        $this->assertTrue(User::generateEmail("cleprive"));
    }
}