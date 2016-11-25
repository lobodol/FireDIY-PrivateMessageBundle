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