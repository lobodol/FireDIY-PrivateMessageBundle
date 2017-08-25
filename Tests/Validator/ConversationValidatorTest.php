<?php

namespace FD\PrivateMessageBundle\Tests\Validator;

use FD\PrivateMessageBundle\Entity\Conversation;
use FD\PrivateMessageBundle\Validator\ConversationValidator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * Class ConversationValidatorTest.
 */
class ConversationValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test ConversationValidator::validate() with expected failing data.
     */
    public function testValidateFail()
    {
        /** @var UserInterface $user */
        $user = $this->getMockBuilder(UserInterface::class)->getMock();

        $conversation = new Conversation();
        $conversation->setAuthor($user)
                     ->addRecipient($user);

        $violationBuilder = $this->getMockBuilder(ConstraintViolationBuilderInterface::class)->getMock();
        $violationBuilder->expects($this->once())
                         ->method('addViolation');

        $violationBuilder->expects($this->once())
                         ->method('atPath')
                         ->with($this->equalTo('recipients'))
                         ->willReturn($violationBuilder);

        $context = $this->getMockBuilder(ExecutionContextInterface::class)->getMock();
        $context->expects($this->once())
                ->method('buildViolation')
                ->with($this->equalTo('You cannot send a message to yourself'))
                ->willReturn($violationBuilder);

        ConversationValidator::validate($conversation, $context);
    }
}
