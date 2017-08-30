<?php

namespace FD\PrivateMessageBundle\Security;

use FD\PrivateMessageBundle\Entity\Conversation;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ConversationVoter.
 */
class ConversationVoter extends Voter
{
    const VIEW = 'view';

    const ACTIONS = [self::VIEW];

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, self::ACTIONS) || !$subject instanceof Conversation) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute
     * @param Conversation   $conversation
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $conversation, TokenInterface $token)
    {
        $user = $token->getUser();

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($conversation, $user);
        }

        throw new \LogicException(sprintf('Unknown action %s', $attribute));
    }

    /**
     * A user must be one of the recipients of the conversation to see it.
     *
     * @param Conversation  $conversation
     * @param UserInterface $user
     *
     * @return bool
     */
    private function canView(Conversation $conversation, UserInterface $user)
    {
        return $conversation->getRecipients()->contains($user);
    }
}
