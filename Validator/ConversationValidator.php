<?php

namespace FD\PrivateMessageBundle\Validator;

use FD\PrivateMessageBundle\Entity\Conversation;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class ConversationValidator.
 */
class ConversationValidator
{
    /**
     * Error message when user set himself as recipient of the conversation.
     */
    const RECIPIENT_VIOLATION = 'You cannot send a message to yourself';

    /**
     * Entry point of the conversation's validation process.
     *
     * @param Conversation              $conversation : The conversation object to validate.
     * @param ExecutionContextInterface $context      : The execution context object.
     */
    public static function validate(Conversation $conversation, ExecutionContextInterface $context)
    {
        if ($context->getGroup() == 'creation') {
            self::validateRecipients($conversation, $context);
        }
    }

    /**
     * Make sure the author of the conversation is not sending a message to himself.
     *
     * @param Conversation              $conversation : The conversation object to validate.
     * @param ExecutionContextInterface $context      : The execution context object.
     */
    private static function validateRecipients(Conversation $conversation, ExecutionContextInterface $context)
    {
        $recipients = $conversation->getRecipients();

        if ($recipients->contains($conversation->getAuthor())) {
            $context
                ->buildViolation(self::RECIPIENT_VIOLATION)
                ->atPath('recipients')
                ->addViolation();
        }
    }
}
