<?php

namespace FireDIY\PrivateMessageBundle\Validator;

use FireDIY\PrivateMessageBundle\Entity\Conversation;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class ConversationValidator
 * @package FireDIY\PrivateMessageBundle\Validator
 */
class ConversationValidator
{
    const RECIPIENT_VIOLATION = 'You cannot send a message to yourself';

    /**
     * Entry point of the conversation's validation process.
     *
     * @param Conversation              $conversation : instance of the conversation to validate.
     * @param ExecutionContextInterface $context      : instance of the execution context.
     */
    public static function validate(Conversation $conversation, ExecutionContextInterface $context)
    {
        self::validateRecipients($conversation, $context);
    }

    /**
     * Make sure the author of the conversation is not sending a message to himself.
     *
     * @param Conversation              $conversation : instance of the conversation to validate.
     * @param ExecutionContextInterface $context      : instance of the execution context.
     */
    private static function validateRecipients(Conversation $conversation, ExecutionContextInterface $context)
    {
        if (in_array($conversation->getAuthor(), $conversation->getRecipients())) {
            $context
                ->buildViolation(self::RECIPIENT_VIOLATION)
                ->atPath('recipients')
                ->addViolation();
        }
    }
}
