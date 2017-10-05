<?php

namespace FD\PrivateMessageBundle\Tests\Routing;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RoutingTest.
 */
class RoutingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider routeProvider
     *
     * @param string $routeName
     * @param string $path
     * @param array  $methods
     */
    public function testLoadRouting($routeName, $path, array $methods)
    {
        $locator    = new FileLocator();
        $loader     = new YamlFileLoader($locator);
        $collection = new RouteCollection();
        $collection->addCollection($loader->load(__DIR__.'/../../Resources/config/routing.yml'));

        $route = $collection->get($routeName);
        $this->assertNotNull($route, sprintf('The route "%s" should exists', $routeName));
        $this->assertSame($path, $route->getPath());
        $this->assertSame($methods, $route->getMethods());
    }

    /**
     * @return array
     */
    public function routeProvider()
    {
        return [
            ['fdpm_list_conversations', '/conversation', []],
            ['fdpm_new_conversation', '/conversation/new', []],
            ['fdpm_show_conversation', '/conversation/{conversation}', []],
            ['fdpm_leave_conversation', '/conversation/{conversation}/leave', []],
        ];
    }
}
