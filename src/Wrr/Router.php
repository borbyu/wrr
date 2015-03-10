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
 * Class Router
 *
 * @package Wrr
 * @author  borbyu
 */
class Router
{
    /**
     * @var string
     */
    private $uriBase = '';

    /**
     * @var null|Request
     */
    private $request = null;

    /**
     * @var array
     */
    private $routes = array();

    /**
     * @param string $uriBase
     */
    public function __construct($uriBase = "")
    {
        $this->uriBase = $uriBase;
    }

    /**
     * @param RouteInterface $route
     * @return $this
     */
    public function registerRoute(RouteInterface $route)
    {
        array_unshift($this->routes, $route);
        return $this;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @param string $uriBase
     * @return $this
     */
    public function setUriBase($uriBase)
    {
        $this->uriBase = $uriBase;
        return $this;
    }

    /**
     * @return string
     */
    public function getUriBase()
    {
        return $this->uriBase;
    }

    /**
     * Process Route
     * @return \Wrr\Response\AbstractResponse
     * @throws \RunTimeException
     */
    public function route()
    {
        if ($this->getUriBase()) {
            $this->request->setUriBase($this->getUriBase());
        }
        foreach ($this->routes as $route) {
            /* @var \Wrr\RouteInterface $route */
            if ($route->match($this->request)) {
                return $route->route();
            }
        }
        throw new \RuntimeException('Resource Not Found', 404);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
