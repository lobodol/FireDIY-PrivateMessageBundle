<?php

namespace FD\PrivateMessageBundle\Tests\DependencyInjection;

use FD\PrivateMessageBundle\DependencyInjection\FDPrivateMessageExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class FDPrivateMessageExtensionTest.
 */
class FDPrivateMessageExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test load.
     */
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $loader    = new FDPrivateMessageExtension();
        $config    = [];
        $loader->load($config, $container);

        $this->assertEquals('fd_private_message', $loader->getAlias());
    }
}
