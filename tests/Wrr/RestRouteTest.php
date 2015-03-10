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

use Wrr\Route\RestRoute;

/**
 * Class RestRouteTest
 *
 * @package Wrr
 * @author  borbyu
 */
class RestRouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testRestRouteInstance()
    {
        $fun = function () { return 'abc'; };
        $response = $this->getMock('Wrr\AbstractResponse');
        $route = new RestRoute('abc', $fun, 'GET', $response);
        $this->assertTrue($route instanceof RestRoute);

    }

    /**
     * @test
     */
    public function testRoute()
    {
        $fun = function () { return 'abc'; };
        $response = $this->getMock('Wrr\AbstractResponse');
        $route = new RestRoute('abc', $fun, 'GET', $response);
        $this->assertTrue($route instanceof RestRoute);

        $response = $route->route();
        $this->assertInstanceOf('Wrr\AbstractResponse', $response);
    }

    /**
     * @test
     */
    public function testMatch()
    {
        $fun = function () { return 'abc'; };
        $response = $this->getMock('Wrr\AbstractResponse');
        $route = new RestRoute('def', $fun, 'GET', $response);

        $request = $this->getMockBuilder('Wrr\Request')->getMock();
        $request->expects($this->any())
            ->method('getUriBase')
            ->will($this->returnValue('/abc'));
        $request->expects($this->any())
            ->method('getRequestUri')
            ->will($this->returnValue('/abc/def'));
        $request->expects($this->any())
            ->method('getRequestMethod')
            ->will($this->returnValue('GET'));


        $this->assertTrue($route->match($request));
    }

}
