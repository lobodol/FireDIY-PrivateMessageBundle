FDPrivateMessageBundle
====================

# Configuration
Create your own User entity and tell FDPrivateMessageBundle to use it :
```
doctrine:
    orm:
        resolve_target_entities:
            Symfony\Component\Security\Core\User\UserInterface: AcmeBundle\Entity\YourUserEntiy
```

The only requirement is your User entity must implement the Symfony\Component\Security\Core\User\UserInterface

# Form
You are able to override FDPrivateMessageBundle's forms.

In example, you're using FOSUserBundle and want to load only recipients being NOT locked :

```
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use FireDIY\PrivateMessageBundle\Form\ConversationType as BaseType;


// Make your form extends FDPrivateMessageBunde::ConversationType.
class ConversationType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Call parent's builder.
        parent::buildForm($builder, $options);


        // Load only users being enabled.
        $builder->add('recipients', EntityType::class, array(
            'class'    => 'AcmeBundle:YourUserEntity',
            'multiple' => true,
            'query_builder => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.locked', false');
            },
        ));

    }
}


```