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

use Wrr\Response\ResponseInterface;
use Wrr\Route\HttpRoute;

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
     * @var array
     */
    private $routes = [];

    /**
     * @param Request $request
     */
    public function __construct(Request $request = null)
    {
        $this->request = $request ?: Request::populateFromGlobals();
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
     * @return \Wrr\Response\ResponseInterface
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

    /**
     * @param string $pattern
     * @param string $method
     * @param \Closure $callable
     * @return HttpRoute
     */
    public function registerHttpRoute($pattern, $method, \Closure $callable)
    {
        return $this->registerRoute(
            new HttpRoute($pattern, $callable, $method)
        );
    }

    /**
     * @param Controller $controller
     * @return HttpRoute
     */
    public function registerControllerRoute(Controller $controller)
    {
        return $this->registerHttpRoute(
            $controller->getPattern(),
            $controller->getMethod(),
            function () use ($controller) {
                return $controller->dispatch();
            }
        );
    }

    /**
     * @param null|int $responseCode
     * @param array $headers
     * @return ResponseInterface
     */
    public function respond($responseCode = null, array $headers = [])
    {
        $response = $this->route();
        return $response->setResponseCode($responseCode)
            ->addHeader($headers)
            ->deliverPayload();
    }
}
