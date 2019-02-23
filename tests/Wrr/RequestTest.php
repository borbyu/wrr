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

use PHPUnit\Framework\TestCase;

/**
 * Class RequestTest
 * @package Wrr
 */
class RequestTest extends TestCase
{
    /**
     * mock helper
     */
    private function mockServerGlobal()
    {
        $_SERVER = [
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
            "REQUEST_TIME" => 1385966801
        ];
    }

    public function testConstruct()
    {
        $request = new Request();
        $this->assertTrue($request instanceof Request);

        $request = new Request('/test');
        $this->assertTrue($request->getRequestUri() === '/test');
    }

    public function testPopulateFromGlobals()
    {
        $this->mockServerGlobal();
        $_GET = [1=>1];
        $_POST = [5=>2];
        $_COOKIE = [2=>3];
        $_FILES = [9=>4];

        $request = Request::populateFromGlobals();
        $this->assertTrue(is_object($request));
    }

    public function testGetSetRequestVars()
    {
        $this->mockServerGlobal();

        $request = Request::populateFromGlobals();
        $request->setRequestVar('get', 'foo', 'bar');
        $vars = $request->getRequestVars();
        $this->assertTrue($vars['get']['foo'] === 'bar');

        $request->setRequestVar('baz', 'abc', 'def');
        $vars = $request->getRequestVars();
        $this->assertTrue($vars['baz']['abc'] === 'def');

        $request->setRequestVars(['a' => 'b', 'c'=> 'd']);
        $vars = $request->getRequestVars();
        $this->assertTrue($vars['a'] === 'b');
        $this->assertTrue($vars['c'] === 'd');
        $this->assertTrue(!isset($var['baz']));
    }

    public function testGetSetRequestBody()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRequestBody('abc');
        $this->assertTrue($request->getRequestBody() === 'abc');
    }

    public function testGetSetUserAgent()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setUserAgent('abc');
        $this->assertTrue($request->getUserAgent() === 'abc');
    }

    public function testGetSetEndPoint()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRequestEndPoint('abc');
        $this->assertTrue($request->getRequestEndPoint() === 'abc');
    }

    public function testGetSetMethod()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRequestMethod('abc');
        $this->assertTrue($request->getRequestMethod() === 'abc');
    }

    public function testGetSetRemoteAddr()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRemoteAddr('abc');
        $this->assertTrue($request->getRemoteAddr() === 'abc');
    }

    public function testGetSetRequestTime()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRequestTime('abc');
        $this->assertTrue($request->getRequestTime() === 'abc');
    }

    public function testGetSetQueryString()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setQueryString('abc');
        $this->assertTrue($request->getQueryString() === 'abc');
    }

    public function testGetSetRequestHeaders()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setRequestHeaders(['array!']);
        $this->assertTrue($request->getRequestHeaders() == ['array!']);
    }

    public function testGetSetUriBase()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $request->setUriBase('abc');
        $this->assertTrue($request->getUriBase() === 'abc');
    }
}
