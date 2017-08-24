<?php

namespace FD\PrivateMessageBundle\Tests\Entity;

use FD\PrivateMessageBundle\Entity\Conversation;
use FD\PrivateMessageBundle\Entity\PrivateMessage;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class PrivateMessageTest.
 */
class PrivateMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getter/setter of field author.
     */
    public function testAuthor()
    {
        /** @var UserInterface $author */
        $author  = $this->getMock(UserInterface::class);
        $message = new PrivateMessage();
        $this->assertNull($message->getAuthor());

        $message->setAuthor($author);
        $this->assertSame($author, $message->getAuthor());
    }

    /**
     * Test getter/setter of field body.
     */
    public function testBody()
    {
        $message = new PrivateMessage();
        $this->assertNull($message->getBody());

        $message->setBody('foo');
        $this->assertSame('foo', $message->getBody());
    }

    /**
     * Test getter/setter of field conversation.
     */
    public function testConversation()
    {
        $conversation = new Conversation();
        $message      = new PrivateMessage();
        $this->assertNull($message->getConversation());

        $message->setConversation($conversation);
        $this->assertSame($conversation, $message->getConversation());
    }

    /**
     * Test getter/setter of field created.
     */
    public function testCreated()
    {
        $now = new \DateTime();
        $message = new PrivateMessage();
        $this->assertEquals($now, $message->getCreated(), '', 1);

        $expected = new \DateTime('2001-01-01');
        $message->setCreated($expected);
        $this->assertSame($expected, $message->getCreated());
    }
}
