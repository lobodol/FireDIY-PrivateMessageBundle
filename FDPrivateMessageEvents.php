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
     * This event allows you to access the created conversation & author.
     *
     * @Event("FD\PrivateMessageBundle\Event\ConversationEvent")
     */
    const CONVERSATION_CREATED = 'fd_private_message.conversation.created';

    /**
     * The CONVERSATION_LEFT event occurs when a user leaves a conversation.
     *
     * This event allows you to access the related conversation & user.
     *
     * @Event("FD\PrivateMessageBundle\Event\ConversationEvent")
     */
    const CONVERSATION_LEFT = 'fd_private_message.conversation.left';
}
