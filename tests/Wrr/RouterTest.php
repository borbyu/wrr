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
 * @package Wrr
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Request
     */
    private function mockRequest()
    {
        $mock = $this->getMockBuilder(Request::class)->disableOriginalConstructor();
        return $mock->getMock();
    }

    /**
     * @test
     */
    public function testRouterInstance()
    {
        $router = new Router($this->mockRequest());
        $this->assertTrue($router instanceof Router);
    }
}
