<?php

namespace FD\PrivateMessageBundle\Tests\Form;

use FD\PrivateMessageBundle\Entity\PrivateMessage;
use FD\PrivateMessageBundle\Form\PrivateMessageType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class PrivateMessageTypeTest.
 */
class PrivateMessageTypeTest extends TypeTestCase
{
    /**
     * Test form submission.
     */
    public function testSubmitValidData()
    {
        $formData = [
            'body' => 'Foo body',
        ];

        $form = $this->factory->create(PrivateMessageType::class);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());

        $expected = new PrivateMessage();
        $expected->setBody('Foo body');

        $this->assertEquals($expected, $form->getData(), '', 1);

        $view     = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
