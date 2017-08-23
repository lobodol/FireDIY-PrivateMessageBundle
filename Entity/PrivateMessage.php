<?php

namespace FD\PrivateMessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * PrivateMessage
 *
 * @ORM\Table(name="fdpm_private_message")
 * @ORM\Entity(repositoryClass="FD\PrivateMessageBundle\Repository\PrivateMessageRepository")
 */
class PrivateMessage
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
     * @var \Symfony\Component\Security\Core\User\UserInterface
     *
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     * @Assert\NotBlank()
     */
    private $body;

    /**
     * @var Conversation
     *
     * @ORM\ManyToOne(targetEntity="FD\PrivateMessageBundle\Entity\Conversation", inversedBy="messages", cascade={"remove"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\Valid()
     */
    private $conversation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     * @Assert\DateTime()
     */
    private $created;

    /**
     * PrivateMessage constructor.
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
     * Set author
     *
     * @param UserInterface $author
     *
     * @return PrivateMessage
     */
    public function setAuthor(UserInterface $author)
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

    /**
     * Set body
     *
     * @param string $body
     *
     * @return PrivateMessage
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set conversation
     *
     * @param Conversation $conversation
     *
     * @return PrivateMessage
     */
    public function setConversation(Conversation $conversation)
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return PrivateMessage
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
}
