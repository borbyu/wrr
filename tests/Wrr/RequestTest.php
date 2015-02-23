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

use Wrr\Request;

/**
 * Class RouterTest
 *
 * @package Wrr
 * @author  jwoys
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
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

    public function testAssertTrue()
    {
        $this->assertTrue(true);
    }

    public function testGetRoutingPath()
    {
        $this->mockServerGlobal();
        $request = Request::populateFromGlobals();
        $this->assertTrue(is_object($request));
    }

}
