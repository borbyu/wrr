<?php
/**
 * This file is part of the Wrr package.
 *
 * (c) Jason Woys <jason@woys.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Wrr;

/**
 * Class RouterTest
 *
 * @package Wrr
 * @author  borbyu
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function testRouterInstance()
    {
        $router = new Router();
        $this->assertTrue($router instanceof Router);
    }

    /**
     * @test
     */
    public function testRegisterRoute()
    {
        $router = new Router();
        $routeMock = $this->getMockBuilder('Wrr\RouteInterface')->getMock();
        /** @noinspection PhpParamsInspection */
        $router->registerRoute($routeMock);
    }

    /**
     *
     */
    public function testGetSetUriBase()
    {
        $router = new Router();
        $router = $router->setUriBase('abc');
        $this->assertInstanceOf('Wrr\Router', $router);
        $this->assertTrue($router->getUriBase() == 'abc');
    }

    /**
     * @test
     */
    public function testGetSetRequest()
    {
        $router = new Router();
        $request = $this->getMock('Wrr\Request');
        $router = $router->setRequest($request);
        $this->assertInstanceOf('Wrr\Router', $router);
        $this->assertInstanceOf('Wrr\Request', $router->getRequest());
    }

    /**
     * @test
     */
    public function testRoute()
    {
        $router = new Router();
        $routeMock = $this->getMockBuilder('Wrr\RouteInterface')->getMock();
        $routeMock->expects($this->any())
            ->method('match')
            ->withAnyParameters()
            ->will($this->returnValue(true));
        $router->registerRoute($routeMock);
        $router->setUriBase('abc');
        $request = $this->getMock('Wrr\Request');
        $router = $router->setRequest($request);

        $router->route();
    }

    /**
     * @test
     * @expectedException \RunTimeException
     */
    public function testRouteException()
    {
        $router = new Router();
        $routeMock = $this->getMockBuilder('Wrr\RouteInterface')->getMock();
        $routeMock->expects($this->any())
            ->method('match')
            ->withAnyParameters()
            ->will($this->returnValue(false));
        $router->registerRoute($routeMock);
        $router->setUriBase('abc');
        $request = $this->getMock('Wrr\Request');
        $router = $router->setRequest($request);

        $router->route();
    }
}
