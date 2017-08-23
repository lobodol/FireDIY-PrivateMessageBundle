<?php

namespace FD\PrivateMessageBundle\Event;

use FD\PrivateMessageBundle\Entity\Conversation;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ConversationEvent.
 */
class ConversationEvent extends Event
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Conversation
     */
    protected $conversation;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * ConversationEvent constructor.
     *
     * @param Conversation  $conversation
     * @param Request       $request
     * @param UserInterface $user
     */
    public function __construct(Conversation $conversation, Request $request, UserInterface $user)
    {
        $this->conversation = $conversation;
        $this->request      = $request;
        $this->user         = $user;
    }

    /**
     * Get conversation.
     *
     * @return Conversation
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * Get request.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get user.
     *
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}
