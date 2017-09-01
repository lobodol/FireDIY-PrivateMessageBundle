FDPrivateMessageBundle
======================

[![Build Status](https://travis-ci.org/lobodol/FireDIY-PrivateMessageBundle.svg?branch=master)](https://travis-ci.org/lobodol/FireDIY-PrivateMessageBundle)
[![Coverage Status](https://coveralls.io/repos/github/lobodol/FireDIY-PrivateMessageBundle/badge.svg?branch=master)](https://coveralls.io/github/lobodol/FireDIY-PrivateMessageBundle?branch=master)
[![Total Downloads](https://poser.pugx.org/firediy/private-message-bundle/downloads.svg)](https://packagist.org/packages/firediy/private-message-bundle)

This bundle provides a conversation system to your users.

[![knpbundles.com](http://knpbundles.com/lobodol/FireDIY-PrivateMessageBundle/badge-short)](http://knpbundles.com/lobodol/FireDIY-PrivateMessageBundle)

# Requirements
* Symfony >= 2.8
* A user class implementing ```Symfony\Component\Security\Core\User\UserInterface```

# Translations
If you wish to use default texts provided in this bundle, you have to make sure you have translator enabled in your config.
```yml
# app/config/config.yml
framework:
    translator: ~
```

# Installation
## Step 1: Download FDPrivateMessageBundle using composer
Require the bundle with composer:
```
composer require firediy/private-message-bundle dev-master
```

## Step 2:  Enable the bundle
Enable the bundle in the kernel:
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FD\PrivateMessageBundle\FDPrivateMessageBundle(),
        // ...
    );
}
```

## Step 3: Create your own User class
The goal of this bundle is to provide a private message system to allow users communicating between them.
FDPrivateMessageBundle does not provide a ready-to-use User entity but uses Symfony's UserInterface.

So, you just have to create your own User class implementing ```Symfony\Component\Security\Core\User\UserInterface```.
You can even use FOSUserBundle.

## Step 4: Configure your application's config.yml
Now you have your User entity, you just have to tell FDPrivateMessageBundle to use it :
```yml
# app/config/config.yml
doctrine:
    orm:
        resolve_target_entities:
            Symfony\Component\Security\Core\User\UserInterface: AcmeBundle\Entity\YourUserEntiy
```

## Step 5: Import FDPrivateMessageBundle routing files
Now that you have activated and configured the bundle, all that is left to do is import the FDPrivateMessageBundle routing files.


```yml
# app/config/routing.yml
fd_private_message:
    resource: "@FDPrivateMessageBundle/Resources/config/routing.yml"
```

## Step 6: Update your database schema
Finally, just update your database schema :
```
php bin/console doctrine:schema:update --force
```


# Form
You are able to override FDPrivateMessageBundle's forms.

In example, you're using FOSUserBundle and want to load only recipients being NOT locked :

```php
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use FD\PrivateMessageBundle\Form\ConversationType as BaseType;


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
            'class'         => 'AcmeBundle:YourUserEntity',
            'multiple'      => true,
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where('u.locked', false);
            },
        ));

    }
}
```

# Override default FDPrivateMessageBundle templates
## Example: Override the conversation's show.html.twig template
Just create a new file in ```app/Resources/FDPrivateMessageBundle/views/Conversation/show.html.twig```
```twig
<h1>Overridden template</h1>

<h2>{{ conversation.subject }}</h2>

<ul>
    {% for message in conversation.messages %}
        <li>
            <p>{{ message.author }}, {{ message.created | date('Y-m-d H:i:s') }}</p>
            <div>{{ message.body | raw }}</div>
        </li>
    {% endfor %}
</ul>
```
