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
use Wrr\Response\AbstractResponse;
use Wrr\RouteInterface;

/**
 * Class RestRoute
 *
 * @package Wrr
 * @author  borbyu
 */
class RestRoute implements RouteInterface
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
     * @var AbstractResponse
     */
    private $response;

    /**
     * @param string $pattern
     * @param \Closure $function
     * @param string $method
     * @param AbstractResponse $response
     */
    public function __construct (
        $pattern,
        \Closure $function,
        $method,
        AbstractResponse $response
    ) {
        $this->pattern = $pattern;
        $this->function = $function;
        $this->method = $method;
        $this->response = $response;
    }

    /**
     * Do the routing and call the closure
     *
     * @return AbstractResponse
     * @throws \Exception
     */
    public function route()
    {
        if (is_callable($this->function)) {
            $fun = $this->function;
            $result = $fun();
            if (is_scalar($result)) {
                $this->response->addBodyFragment($result);
            } elseif (method_exists($this->response, 'setData')) {
                $this->response->setData($result);
            } else {
                throw new \Exception('No Result to Route', 500);
            }
        }
        return $this->response;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function match(Request $request)
    {
        $pattern = $request->getRelativeUri();
        return $this->matchesPattern($pattern, $request->getRequestMethod());
    }

    /**
     * @param string $toMatch
     * @param string $method
     * @return bool
     */
    private function matchesPattern($toMatch, $method)
    {
        $regex = "@" . $this->pattern . "@";
        return (bool) preg_match($regex, $toMatch) && $method == $this->method;
    }
}
