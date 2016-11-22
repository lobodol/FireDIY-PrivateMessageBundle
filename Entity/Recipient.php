<?php

namespace FireDIY\PrivateMessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Recipient
 *
 * @ORM\Table(name="recipient")
 * @ORM\Entity(repositoryClass="FireDIY\PrivateMessageBundle\Repository\RecipientRepository")
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="FireDIY\PrivateMessageBundle\Entity\Conversation")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $conversation;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="FireDIY\PrivateMessageBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
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
     * @param integer $conversation
     *
     * @return Recipient
     */
    public function setConversation($conversation)
    {
        $this->conversation = $conversation;

        return $this;
    }

    /**
     * Get conversation
     *
     * @return int
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

