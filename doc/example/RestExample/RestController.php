<?php
/**
 * This file is part of the Wrr package.
 *
 * (c) Jason Woys <jason@woys.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class RestController
 *
 * @author borbyu
 */
class RestController
{
    /**
     * @var Wrr\Request
     */
    private $request = null;
    private $router = null;

    /**
     * @param \Wrr\Request $request
     */
    public function __construct(Wrr\Router $router, Wrr\Request $request)
    {
        $this->request = $request;
        $this->router = $router;
    }

    /**
     * @return array
     */
    public function dispatch()
    {
        return ($this->request->getRequestMethod() == 'POST')
            ? $this->postTest()
            : $this->getTest();
    }

    /**
     * @return array
     */
    public function getTest()
    {
        return array("test"=>"get");
    }

    /**
     * @return array
     */
    public function postTest()
    {
        return array("test"=>"post");
    }
}
