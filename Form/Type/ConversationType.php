<?php

namespace FD\PrivateMessageBundle\Form\Type;

use FD\PrivateMessageBundle\Entity\Conversation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ConversationType.
 */
class ConversationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipients', null, array(
                'label'              => 'form.recipients',
                'translation_domain' => 'FDPrivateMessageBundle',
            ))
            ->add('subject', null, array(
                'label'              => 'form.subject',
                'translation_domain' => 'FDPrivateMessageBundle',
            ))
            ->add('firstMessage', PrivateMessageType::class, array(
                'label' => false,
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'FD\PrivateMessageBundle\Entity\Conversation',
            'validation_groups' => [$this, 'determineValidationGroups'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'firediy_privatemessagebundle_conversation';
    }

    /**
     * Guess validation group from conversation object.
     *
     * @param FormInterface $form
     *
     * @return string[]
     */
    public function determineValidationGroups(FormInterface $form)
    {
        /** @var Conversation $conversation */
        $conversation = $form->getData();

        if ($conversation->getId() === null) {
            return ['creation'];
        }

        return ['edition'];
    }
}
