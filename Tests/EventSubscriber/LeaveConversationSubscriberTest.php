<?php

namespace FD\PrivateMessageBundle\Tests\EventSubscriber;

use Doctrine\ORM\EntityManager;
use FD\PrivateMessageBundle\Entity\Conversation;
use FD\PrivateMessageBundle\Event\ConversationEvent;
use FD\PrivateMessageBundle\EventSubscriber\LeaveConversationSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class LeaveConversationSubscriberTest.
 */
class LeaveConversationSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test LeaveConversationSubscriber::getSubscribedEvents().
     */
    public function testSubscribedEvents()
    {
        $expected = ['fd_private_message.conversation.left' => 'onConversationLeft'];

        $this->assertEquals($expected, LeaveConversationSubscriber::getSubscribedEvents());
    }

    /**
     * Test onConversationLeft with a conversation having no more recipients.
     */
    public function testOnConversationLeftRemove()
    {
        /** @var Request $request */
        $request = $this->getMockBuilder(Request::class)->getMock();
        /** @var UserInterface $user */
        $user    = $this->getMockBuilder(UserInterface::class)->getMock();
        $em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $em->expects($this->once())->method('remove');
        $em->expects($this->once())->method('flush');

        $service      = new LeaveConversationSubscriber($em);
        $conversation = new Conversation();
        $event        = new ConversationEvent($conversation, $request, $user);

        $service->onConversationLeft($event);
    }

    /**
     * Test onConversationLeft with a conversation still having recipients.
     */
    public function testOnConversationLeft()
    {
        /** @var Request $request */
        $request = $this->getMockBuilder(Request::class)->getMock();
        /** @var UserInterface $user */
        $user    = $this->getMockBuilder(UserInterface::class)->getMock();
        $em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $em->expects($this->never())->method('remove');
        $em->expects($this->never())->method('flush');

        $conversation = new Conversation();
        $conversation->addRecipient($user);

        $service      = new LeaveConversationSubscriber($em);
        $event        = new ConversationEvent($conversation, $request, $user);

        $service->onConversationLeft($event);
    }
}
