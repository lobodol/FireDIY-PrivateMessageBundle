<?php

namespace FireDIY\PrivateMessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Conversation
 *
 * @ORM\Table(name="conversation", uniqueConstraints={@UniqueConstraint(name="unique_conversation", columns={"first_message"})})
 * @ORM\Entity(repositoryClass="FireDIY\PrivateMessageBundle\Repository\ConversationRepository")
 * @UniqueEntity(
 *     fields={"first_message"},
 *     message="Cannot duplicate a conversation"
 * )
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
     * @ORM\OneToMany(targetEntity="FireDIY\PrivateMessageBundle\Entity\Recipient", mappedBy="conversation")
     */
    private $recipients;

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
     * @var \Symfony\Component\Security\Core\User\UserInterface
     *
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     * @Assert\Valid()
     */
    private $author;

    /**
     * @var PrivateMessage
     *
     * @ORM\OneToOne(targetEntity="FireDIY\PrivateMessageBundle\Entity\PrivateMessage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL", name="first_message")
     * @Assert\Valid()
     */
    private $firstMessage;

    /**
     * @var PrivateMessage
     *
     * @ORM\OneToOne(targetEntity="FireDIY\PrivateMessageBundle\Entity\PrivateMessage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
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
     * @return PrivateMessage
     */
    public function getFirstMessage()
    {
        return $this->firstMessage;
    }

    /**
     * Set lastMessage
     *
     * @param PrivateMessage $lastMessage
     *
     * @return Conversation
     */
    public function setLastMessage(PrivateMessage $lastMessage)
    {
        $this->lastMessage = $lastMessage;

        return $this;
    }

    /**
     * Get lastMessage
     *
     * @return PrivateMessage
     */
    public function getLastMessage()
    {
        return $this->lastMessage;
    }

    /**
     * Add message
     *
     * @param PrivateMessage $message
     *
     * @return Conversation
     */
    public function addMessage(PrivateMessage $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param PrivateMessage $message
     */
    public function removeMessage(PrivateMessage $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add recipient
     *
     * @param Recipient $recipient
     *
     * @return Conversation
     */
    public function addRecipient(Recipient $recipient)
    {
        $this->recipients[] = $recipient;

        return $this;
    }

    /**
     * Remove recipient
     *
     * @param Recipient $recipient
     */
    public function removeRecipient(Recipient $recipient)
    {
        $this->recipients->removeElement($recipient);
    }

    /**
     * Get recipients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Set author
     *
     * @param UserInterface $author
     *
     * @return Conversation
     */
    public function setAuthor(UserInterface $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return UserInterface
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
