<?php

namespace FD\PrivateMessageBundle\Tests\Form;

use FD\PrivateMessageBundle\Entity\Conversation;
use FD\PrivateMessageBundle\Entity\PrivateMessage;
use FD\PrivateMessageBundle\Form\Type\ConversationType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ConversationTypeTest.
 */
class ConversationTypeTest extends TypeTestCase
{
    /**
     * Test form submission.
     */
    public function testSubmitValidData()
    {
        $recipient = $this->getMockBuilder(UserInterface::class)->getMock();
        $message   = new PrivateMessage();
        $expected  = new Conversation();
        $expected->addRecipient($recipient)
                 ->setFirstMessage($message->setBody('Foo message'))
                 ->setSubject('Foo subject');

        $formData = [
            'recipients'   => [$recipient],
            'firstMessage' => ['body' => 'Foo message'],
            'subject'      => 'Foo subject',
        ];

        $form = $this->factory->create(ConversationType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $form->getData(), '', 1);

        $view     = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    /**
     * Test ConversationType::determineValidationGroups().
     */
    public function testDetermineValidationGroups()
    {
        // Test with a new conversation object (having no ID yet).
        $conversation  = $this->getMockBuilder(Conversation::class)->getMock();
        $form          = new ConversationType();
        $formInterface = $this->factory->create(ConversationType::class, $conversation);
        $actual        = $form->determineValidationGroups($formInterface);

        $this->assertEquals(['creation'], $actual);

        // Test with an existing conversation (having an ID).
        $conversation->method('getId')->willReturn(1);
        $formInterface = $this->factory->create(ConversationType::class, $conversation);
        $actual        = $form->determineValidationGroups($formInterface);

        $this->assertEquals(['edition'], $actual);
    }
}
