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
class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * mock helper
     */
    private function mockServerGlobal()
    {
        $_SERVER = array(
            "HTTP_USER_AGENT" => "test agent",
            "HTTP_HOST" => "23.239.1.38",
            "SERVER_NAME" => "23.239.1.38",
            "SERVER_ADDR" => "23.239.1.38",
            "SERVER_PORT" => "80",
            "REMOTE_ADDR" => "68.50.176.162",
            "SERVER_PROTOCOL" => "HTTP/1.1",
            "REQUEST_METHOD" => "GET",
            "QUERY_STRING" => "",
            "REQUEST_URI" => "/cms/public/",
            "SCRIPT_NAME" => "/cms/public/index.php",
            "PHP_SELF" => "/cms/public/index.php",
            "REQUEST_TIME" => "1385966801"
        );
    }

    /**
     * @test
     */
    public function testConstruct()
    {
        $request = new Request();
        $this->assertTrue($request instanceof Request);

        $request = new Request('/test');
        $this->assertTrue($request->getRequestUri() == '/test' );
    }

    /**
     * @test
     */
    public function testPopulateFromGlobals()
    {
        $this->mockServerGlobal();
        $_GET = array(1=>1);
        $_POST = array(5=>2);
        $_COOKIE = array(2=>3);
        $_FILES = array(9=>4);

        $request = Request::populateFromGlobals();
        $this->assertTrue(is_object($request));
    }

    /**
     * @test
     */
    public function testGetSetRequestVars()
    {
        $this->mockServerGlobal();

        $request = Request::populateFromGlobals();
        $request->setRequestVar('get', 'foo', 'bar');
        $vars = $request->getRequestVars();
        $this->assertTrue($vars['get']['foo'] == 'bar');

        $request->setRequestVar('baz', 'abc', 'def');
        $vars = $request->getRequestVars();
        $this->assertTrue($vars['baz']['abc'] == 'def');

        $request->setRequestVars(array('a' => 'b', 'c'=> 'd'));
        $vars = $request->getRequestVars();
        $this->assertTrue($vars['a'] == 'b');
        $this->assertTrue($vars['c'] == 'd');
        $this->assertTrue(!isset($var['baz']));
    }

    /**
     * @test
     */
    public function testGetSetRequestBody()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRequestBody('abc');
        $this->assertTrue($request->getRequestBody() == 'abc');
    }

    /**
     * @test
     */
    public function testGetSetUserAgent()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setUserAgent('abc');
        $this->assertTrue($request->getUserAgent() == 'abc');
    }

    /**
     * @test
     */
    public function testGetSetEndPoint()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRequestEndPoint('abc');
        $this->assertTrue($request->getRequestEndPoint() == 'abc');
    }

    /**
     * @test
     */
    public function testGetSetMethod()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRequestMethod('abc');
        $this->assertTrue($request->getRequestMethod() == 'abc');
    }

    /**
     * @test
     */
    public function testGetSetRemoteAddr()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRemoteAddr('abc');
        $this->assertTrue($request->getRemoteAddr() == 'abc');
    }

    /**
     * @test
     */
    public function testGetSetRequestTime()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRequestTime('abc');
        $this->assertTrue($request->getRequestTime() == 'abc');
    }

    /**
     * @test
     */
    public function testGetSetQueryString()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setQueryString('abc');
        $this->assertTrue($request->getQueryString() == 'abc');
    }

    /**
     * @test
     */
    public function testGetSetRequestHeaders()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRequestHeaders(array('array!'));
        $this->assertTrue($request->getRequestHeaders() == array('array!'));
    }

    /**
     * @test
     */
    public function testGetSetUriBase()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setUriBase('abc');
        $this->assertTrue($request->getUriBase() == 'abc');
    }
}
