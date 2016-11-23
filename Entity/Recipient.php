<?php

namespace FireDIY\PrivateMessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Recipient
 *
 * @ORM\Table(name="recipient", uniqueConstraints={@UniqueConstraint(name="unique_recipient", columns={"conversation", "user"})})
 * @ORM\Entity(repositoryClass="FireDIY\PrivateMessageBundle\Repository\RecipientRepository")
 * @UniqueEntity(
 *     fields={"conversation", "user"},
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
     * @ORM\JoinColumn(nullable=false, name="conversation")
     * @Assert\Valid()
     */
    private $conversation;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="FireDIY\PrivateMessageBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, name="user")
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
     * @param integer $user
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
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }
}

