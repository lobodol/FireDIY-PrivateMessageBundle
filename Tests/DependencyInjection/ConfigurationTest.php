<?php

namespace FD\PrivateMessageBundle\Tests\DependencyInjection;

use FD\PrivateMessageBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class ConfigurationTest.
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test dependency injection configuration.
     */
    public function testGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $actual        = $configuration->getConfigTreeBuilder();
        $expected      = new TreeBuilder();

        $this->assertEquals($expected, $actual);
    }
}
