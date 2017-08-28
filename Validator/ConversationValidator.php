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
     * Error message when user selected more than MAX_RECIPIENTS recipients.
     */
    const RECIPIENT_NUMBER_VIOLATION = 'You cannot add more than %d recipients';

    /**
     * Maximum number of recipients for a conversation.
     */
    const MAX_RECIPIENTS = 7;

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

        self::validateRecipientsNumber($conversation, $context);
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

    /**
     * Make sure author has not selected too much recipients.
     *
     * @param Conversation              $conversation : The conversation object to validate.
     * @param ExecutionContextInterface $context      : The context object.
     */
    private static function validateRecipientsNumber(Conversation $conversation, ExecutionContextInterface $context)
    {
        $max = self::MAX_RECIPIENTS;

        // When conversation has been created, author is part of the recipients.
        if ($context->getGroup() != 'creation') {
            // Thus, there can be max+1 recipients.
            $max += 1;
        }

        if ($conversation->getRecipients()->count() > $max) {
            $context
                ->buildViolation(sprintf(self::RECIPIENT_NUMBER_VIOLATION, self::MAX_RECIPIENTS))
                ->atPath('recipients')
                ->addViolation();
        }
    }
}
