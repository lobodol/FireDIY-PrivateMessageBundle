<?php

namespace FD\PrivateMessageBundle\Tests\Security;

use FD\PrivateMessageBundle\Entity\Conversation;
use FD\PrivateMessageBundle\Security\ConversationVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ConversationVoterTest.
 */
class ConversationVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The voter object to test.
     *
     * @var ConversationVoter
     */
    private $voter;

    /**
     * @var TokenInterface
     */
    private $token;

    /**
     * Before each test.
     */
    public function setUp()
    {
        $this->voter = new ConversationVoter();

        $this->token = $this->getMockBuilder(TokenInterface::class)
                            ->disableOriginalConstructor()
                            ->getMock();
    }

    /**
     * After each test.
     */
    public function tearDown()
    {
        $this->voter = null;
        $this->token = null;
    }

    /**
     * Expect denied access to view conversation for a user.
     */
    public function testCanViewDenied()
    {
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $this->token->method('getUser')->willReturn($user);

        $conversation = new Conversation();

        $actual = $this->voter->vote($this->token, $conversation, ['view']);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $actual);
    }

    /**
     * Expect granted access to view conversation for a user.
     */
    public function testCanViewGranted()
    {
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $this->token->method('getUser')->willReturn($user);

        $conversation = new Conversation();
        $conversation->addRecipient($user);

        $actual = $this->voter->vote($this->token, $conversation, ['view']);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $actual);
    }

    /**
     * Test vote with not supported attribute.
     */
    public function testDoesNotSupport()
    {
        $conversation = new Conversation();
        $actual = $this->voter->vote($this->token, $conversation, ['foo']);

        $this->assertEquals(VoterInterface::ACCESS_ABSTAIN, $actual);
    }
}
