<?php

namespace FD\PrivateMessageBundle\EventSubscriber;

use Doctrine\ORM\EntityManager;
use FD\PrivateMessageBundle\Event\ConversationEvent;
use FD\PrivateMessageBundle\FDPrivateMessageEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class LeaveConversationSubscriber.
 */
class LeaveConversationSubscriber implements EventSubscriberInterface
{
    /**
     * The entity manager service.
     *
     * @var EntityManager
     */
    private $em;

    /**
     * Do not delete conversations having no more recipients if set to TRUE.
     *
     * @var bool
     */
    private $keepEmptyConversations;

    /**
     * LeaveConversationSubscriber constructor.
     *
     * @param EntityManager $entityManager
     * @param bool          $keepEmptyConversations
     */
    public function __construct(EntityManager $entityManager, $keepEmptyConversations)
    {
        $this->em = $entityManager;
        $this->keepEmptyConversations = $keepEmptyConversations;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FDPrivateMessageEvents::CONVERSATION_LEFT => 'onConversationLeft',
        ];
    }

    /**
     * Make sure to completely remove a conversation if last recipient has left like others.
     *
     * @param ConversationEvent $event : The subscribed event.
     */
    public function onConversationLeft(ConversationEvent $event)
    {
        $conversation = $event->getConversation();

        // If all recipients have left the conversation, remove it.
        if (!$this->keepEmptyConversations && count($conversation->getRecipients()) == 0) {
            $this->em->remove($conversation);
            $this->em->flush();
        }
    }
}
