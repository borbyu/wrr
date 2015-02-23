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
 * @package Wrr
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
     * @var null|Response
     */
    private $response = null;

    /**
     * @var array
     */
    private $routes = array();

    /**
     * @param Response $response
     */
    public function __construct(AbstractResponse $response = null)
    {
        if (is_null($response)) {
            $response = new DefaultResponse();
        }
        $this->response = $response;
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
     * @param Response $response
     * @return $this
     */
    public function setResponse(AbstractResponse $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @param $uriBase
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
     * @return Response
     * @throws \RunTimeException
     */
    public function route()
    {
        foreach ($this->routes as $route) {
            $pattern = str_replace($this->getUriBase(), "", $this->getRequest()->getRequestUri());
            /* @var \Wrr\RouteInterface $route */
            if ($route->matchesPattern($pattern, $this->request->getRequestMethod())) {
                return $route->route($this->response);
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
