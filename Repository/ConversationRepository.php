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
     * Get all conversations of a user being involved in as recipient or author.
     *
     * @param UserInterface $user : instance of the user.
     *
     * @return array
     */
    public function getAllByRecipient(UserInterface $user)
    {
        $qb = $this->createQueryBuilder('c')
            ->join('c.recipients', 'r')
            ->join('c.lastMessage', 'lm')
            ->addSelect('lm')
            ->where('r.id = :user')
            ->setParameter('user', $user)
            ->orderBy('c.created', 'DESC');

        return $qb->getQuery()->getResult();
    }

    /**
     * Get a conversation by ID.
     * Related private messages, authors, recipients are loaded by a JOIN statement.
     *
     * @param int $cid : technical ID of the conversation.
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOneById($cid)
    {
        $qb = $this->createQueryBuilder('c')
            ->join('c.recipients', 'r')
            ->join('c.messages', 'm')
            ->join('m.author', 'a')
            ->addSelect('r')
            ->addSelect('m')
            ->addSelect('a')
            ->where('c.id = :cid')
            ->setParameter('cid', $cid)
            ->orderBy('m.created', 'ASC');

        return $qb->getQuery()->getOneOrNullResult();
    }
}
