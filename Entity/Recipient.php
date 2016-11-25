<?php

namespace FireDIY\PrivateMessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Recipient
 *
 * @ORM\Table(name="recipient", uniqueConstraints={@UniqueConstraint(name="unique_recipient", columns={"conversation_id", "user_id"})})
 * @ORM\Entity(repositoryClass="FireDIY\PrivateMessageBundle\Repository\RecipientRepository")
 * @UniqueEntity(
 *     fields={"conversation_id", "user_id"},
 *     errorPath="user",
 *     message="This user is already in this conversation"
 * )
 */
class Recipient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Conversation
     *
     * @ORM\ManyToOne(targetEntity="FireDIY\PrivateMessageBundle\Entity\Conversation", inversedBy="recipients")
     * @ORM\JoinColumn(nullable=false, name="conversation_id")
     * @Assert\Valid()
     */
    private $conversation;

    /**
     * @var \Symfony\Component\Security\Core\User\UserInterface
     *
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     * @ORM\JoinColumn(nullable=false, name="user_id")
     * @Assert\Valid()
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set conversation
     *
     * @param Conversation $conversation
     *
     * @return Recipient
     */
    public function setConversation(Conversation $conversation)
    {
        $this->conversation = $conversation;

        return $this;
    }

    /**
     * Get conversation
     *
     * @return Conversation
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * Set user
     *
     * @param UserInterface $user
     *
     * @return Recipient
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}

