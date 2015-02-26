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

use Wrr\Request;
use Wrr\Response\DefaultResponse;
use Wrr\RouteInterface;

/**
 * Class DefaultRoute
 *
 * @package Wrr
 * @author  borbyu
 */
class DefaultRoute implements RouteInterface
{
    /**
     * @var string
     */
    private $pattern;
    /**
     * @var \Closure
     */
    private $function;
    /**
     * @var string
     */
    private $method;
    /**
     * @var \Wrr\Response\AbstractResponse
     */
    private $response;
    
    /**
     * @param string $pattern
     * @param \Closure $function
     * @param string $method
     */
    public function __construct($pattern, \Closure $function, $method = "GET")
    {
        $this->pattern = $pattern;
        $this->function = $function;
        $this->method = $method;
        $this->response = new DefaultResponse();
    }

    /**
     * Do the routing and call the closure
     *
     * @return \Wrr\Response\AbstractResponse
     */
    public function route()
    {
        if (is_callable($this->function)) {
            $fun = $this->function;
            $this->response->addBodyFragment($fun());
        }
        return $this->response;
    }
  
    /**
     * @param Request $request
     * @return bool
     */
    public function match(Request $request)
    {
        return $this->matchesPattern($request->getRelativeUri());
    }

    /**
     * @param string $toMatch
     * @param string $method
     * @return bool
     */
    private function matchesPattern($toMatch, $method = "GET")
    {
        $regex = "@" . $this->pattern . "@";
        return (bool) preg_match($regex, $toMatch) && $method == $this->method;
    }
}
