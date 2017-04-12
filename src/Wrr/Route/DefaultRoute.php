<?php
/**
 * This file is part of the Wrr package.
 *
 * (c) Jason Woys <jason@woys.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Wrr\Route;

use Wrr\Response\DefaultResponse;
use Wrr\Response\ResponseInterface;

/**
 * Class DefaultRoute
 * @package Wrr\Route
 */
class DefaultRoute extends HttpRoute
{
    /**
     * @var DefaultResponse
     */
    private $response;

    /**
     * @param string $pattern
     * @param \Closure $function
     * @param string $method
     */
    public function __construct($pattern, \Closure $function, $method = "GET")
    {
        parent::__construct($pattern, $function, $method);
        $this->response = new DefaultResponse();
    }

    /**
     * Do the routing and call the closure
     *
     * @return ResponseInterface
     */
    public function route() : ResponseInterface
    {
        return parent::route();
    }
}
