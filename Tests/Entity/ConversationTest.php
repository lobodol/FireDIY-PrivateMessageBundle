<?php

namespace FD\PrivateMessageBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FD\PrivateMessageBundle\Entity\Conversation;
use FD\PrivateMessageBundle\Entity\PrivateMessage;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ConversationTest.
 */
class ConversationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test subject's getter/setter.
     */
    public function testSubject()
    {
        $conversation = new Conversation();
        $this->assertNull($conversation->getSubject());

        $conversation->setSubject('Foo');
        $this->assertSame('Foo', $conversation->getSubject());
    }

    /**
     * Test getter/setter of field $created.
     */
    public function testCreated()
    {
        $now          = new \DateTime();
        $conversation = new Conversation();
        $this->assertEquals($now, $conversation->getCreated(), '', 1);

        $expected = new \DateTime('2001-01-01');
        $conversation->setCreated($expected);
        $this->assertSame($expected, $conversation->getCreated());
    }

    /**
     * Test getter/setter of field $firstmessage.
     */
    public function testFirstMessage()
    {
        $message      = new PrivateMessage();
        $conversation = new Conversation();
        $this->assertNull($conversation->getFirstMessage());

        $conversation->setFirstMessage($message);
        $this->assertSame($message, $conversation->getFirstMessage());
    }

    /**
     * Test getter/setter of field $lastmessage.
     */
    public function testLastMessage()
    {
        $message      = new PrivateMessage();
        $conversation = new Conversation();
        $this->assertNull($conversation->getLastMessage());

        $conversation->setLastMessage($message);
        $this->assertSame($message, $conversation->getLastMessage());
    }

    /**
     * Test getter/setter of field $messages.
     */
    public function testMessages()
    {
        $message      = new PrivateMessage();
        $conversation = new Conversation();
        $this->assertEmpty($conversation->getMessages());

        $conversation->addMessage($message);
        $this->assertEquals(new ArrayCollection([$message]), $conversation->getMessages());

        $conversation->removeMessage($message);
        $this->assertEmpty($conversation->getMessages());
    }

    /**
     * Test getter/setter of field  $recipients.
     */
    public function testRecipients()
    {
        $recipient    = $this->getMock(UserInterface::class);
        $conversation = new Conversation();
        $this->assertEmpty($conversation->getRecipients());

        $conversation->addRecipient($recipient);
        $this->assertEquals(new ArrayCollection([$recipient]), $conversation->getRecipients());

        $conversation->removeRecipient($recipient);
        $this->assertEmpty($conversation->getRecipients());
    }

    /**
     * Test getter/setter of field $author.
     */
    public function testAuthor()
    {
        $author       = $this->getMock(UserInterface::class);
        $conversation = new Conversation();
        $this->assertNull($conversation->getAuthor());

        $conversation->setAuthor($author);
        $this->assertSame($author, $conversation->getAuthor());
    }
}
