<?php

namespace FD\PrivateMessageBundle\Tests\Event;

use FD\PrivateMessageBundle\Entity\Conversation;
use FD\PrivateMessageBundle\Event\ConversationEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ConversationEventTest.
 */
class ConversationEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test ConversationEvent object.
     */
    public function testConversationEvent()
    {
        $conversation = new Conversation();
        /** @var Request $request */
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        /** @var UserInterface $user */
        $user = $this->getMockBuilder(UserInterface::class)->getMock();

        $event = new ConversationEvent($conversation, $request, $user);

        $this->assertSame($conversation, $event->getConversation());
        $this->assertSame($request, $event->getRequest());
        $this->assertSame($user, $event->getUser());
    }
}
