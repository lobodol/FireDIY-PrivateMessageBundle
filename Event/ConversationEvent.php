<?php

namespace FD\PrivateMessageBundle\Event;

use FD\PrivateMessageBundle\Entity\Conversation;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConversationEvent
 * @package FD\PrivateMessageBundle\Event
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
     * ConversationEvent constructor.
     * @param Conversation $conversation
     * @param Request      $request
     */
    public function __construct(Conversation $conversation, Request $request)
    {
        $this->conversation = $conversation;
        $this->request = $request;
    }

    /**
     * @return Conversation
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
