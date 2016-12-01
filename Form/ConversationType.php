<?php

namespace FD\PrivateMessageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ConversationType
 * @package FD\PrivateMessageBundle\Form
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
            'data_class' => 'FD\PrivateMessageBundle\Entity\Conversation',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'firediy_privatemessagebundle_conversation';
    }
}
