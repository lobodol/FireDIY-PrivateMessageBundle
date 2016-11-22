<?php

namespace FireDIY\PrivateMessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Conversation
 *
 * @ORM\Table(name="conversation")
 * @ORM\Entity(repositoryClass="FireDIY\PrivateMessageBundle\Repository\ConversationRepository")
 */
class Conversation
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
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     * @Assert\Length(min=10)
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     * @Assert\DateTime()
     */
    private $created;

    /**
     * @var PrivateMessage
     *
     * @ORM\OneToOne(targetEntity="FireDIY\PrivateMessageBundle\Entity\PrivateMessage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $firstMessage;

    /**
     * @var PrivateMessage
     *
     * @ORM\OneToOne(targetEntity="FireDIY\PrivateMessageBundle\Entity\PrivateMessage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $lastMessage;

    /**
     * @ORM\OneToMany(targetEntity="FireDIY\PrivateMessageBundle\Entity\PrivateMessage", mappedBy="conversation")
     */
    private $messages;

    /**
     * Conversation constructor.
     */
    public function __construct()
    {
        $this->created = new \DateTime();
    }

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
     * Set title
     *
     * @param string $subject
     *
     * @return Conversation
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Conversation
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set firstMessage
     *
     * @param PrivateMessage $firstMessage
     *
     * @return Conversation
     */
    public function setFirstMessage(PrivateMessage $firstMessage)
    {
        $this->firstMessage = $firstMessage;

        return $this;
    }

    /**
     * Get firstMessage
     *
     * @return int
     */
    public function getFirstMessage()
    {
        return $this->firstMessage;
    }

    /**
     * Set lastMessage
     *
     * @param integer $lastMessage
     *
     * @return Conversation
     */
    public function setLastMessage($lastMessage)
    {
        $this->lastMessage = $lastMessage;

        return $this;
    }

    /**
     * Get lastMessage
     *
     * @return int
     */
    public function getLastMessage()
    {
        return $this->lastMessage;
    }
}

