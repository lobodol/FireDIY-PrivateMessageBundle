<?php

namespace FD\PrivateMessageBundle;

/**
 * Contains all events thrown in the FDPrivateMessageBundle.
 */
final class FDPrivateMessageEvents
{
    /**
     * The CONVERSATION_CREATED event occurs when a user creates a new conversation.
     *
     * This event allows you to access the created conversation.
     *
     * @Event("FD\PrivateMessageBundle\Event\ConversationEvent")
     */
    const CONVERSATION_CREATED = 'fd_private_message.conversation.created';
}
