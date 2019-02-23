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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Wrr\Route\HttpRoute;

/**
 * Class RouterTest
 * @package Wrr
 */
class RouterTest extends TestCase
{
    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     * @throws \ReflectionException
     */
    private function mockRequest()
    {
        $mock = $this->getMockBuilder(Request::class)->disableOriginalConstructor();
        return $mock->getMock();
    }

    /**
     * @throws \ReflectionException
     */
    public function testRouterInstance()
    {
        $router = new Router($this->mockRequest());
        $this->assertInstanceOf(Router::class, $router);
    }

    /**
     * @throws \ReflectionException
     */
    public function testRegisterRoute()
    {
        $router = new Router($this->mockRequest());

        $mockRoute = $this->mock(HttpRoute::class);
        $router = $router->registerRoute($mockRoute);
        $this->assertInstanceOf(Router::class, $router);
    }

    /**
     * @param $name
     * @param array $methods
     * @return \PHPUnit\Framework\MockObject\MockObject
     * @throws \ReflectionException
     */
    protected function mock($name, array $methods = [])
    {
        $mock = $this->getMockBuilder($name)->disableOriginalConstructor();
        if (!empty($methods)) {
            $mock->setMethods($methods);
        }
        return $mock->getMock();
    }

    /**
     * @param MockObject $mock
     * @param $method
     * @param $return
     * @return mixed
     */
    protected function mockMethod(MockObject $mock, $method, $return)
    {
        return $this->mockMethodAndValidate($mock, $method, $return, $this->any());
    }

    /**
     * @param MockObject $mock
     * @param $method
     * @param $return
     * @param $expects
     * @param mixed ...$with
     * @return mixed
     */
    protected function mockMethodAndValidate(
        MockObject $mock,
        $method,
        $return,
        $expects,
        ... $with
    ) {
        $builder = $mock->expects($expects)
            ->method($method);
        if (!empty($with)) {
            $builder = $builder->with(... $with);
        }
        return $builder->will($this->returnValue($return));
    }
}
