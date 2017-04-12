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
use Wrr\Response\HttpResponse;
use Wrr\Response\ResponseInterface;
use Wrr\RouteInterface;

/**
 * Class HttpRoute
 * @package Wrr\Route
 */
class HttpRoute implements RouteInterface
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
     * @var Request
     */
    private $request;
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @param string $pattern
     * @param \Closure $function
     * @param string $method
     */
    public function __construct(
        string $pattern,
        \Closure $function,
        string $method = 'GET'
    ) {
        $this->pattern = $pattern;
        $this->function = $function;
        $this->method = $method;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return HttpResponse
     */
    public function getResponse()
    {
        $this->response = $this->response ?: new HttpResponse();
        return $this->response;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        $this->request = $this->request ?: Request::populateFromGlobals();
        return $this->request;
    }

    /**
     * @param ResponseInterface $response
     * @return HttpRoute
     */
    public function setResponse(ResponseInterface $response) : HttpRoute
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Do the routing and call the closure
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function route() : ResponseInterface
    {
        $fun = $this->function;
        $result = $fun($this->getRequest(), $this->getResponse());
        $this->getResponse()->setPayload($result);
        return $this->getResponse();
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function match(Request $request) : bool
    {
        $pattern = $request->getRelativeUri();
        return $this->matchesPattern($pattern, $request->getRequestMethod());
    }

    /**
     * @param string $toMatch
     * @param string $method
     * @return bool
     */
    protected function matchesPattern($toMatch, $method = "*") : bool
    {
        $regex = "@" . $this->pattern . "@";
        return preg_match($regex, $toMatch)
        && ($this->method == '*' || $method == $this->method)
        && (substr_count($toMatch, '/')) === (substr_count($this->pattern, '/'));
    }
}
