<?php

namespace FD\PrivateMessageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * ConversationRepository
 */
class ConversationRepository extends EntityRepository
{
    /**
     * Get all conversation of a user where he's involved in as recipient or author.
     *
     * @param UserInterface $user : instance of the user.
     * @return array
     */
    public function getAllByRecipient(UserInterface $user)
    {
        $qb = $this->createQueryBuilder('c')
            ->join('c.recipients', 'r')
            ->where('r.id = :user OR c.author = :user')
            ->setParameter('user', $user)
            ->orderBy('c.created', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
