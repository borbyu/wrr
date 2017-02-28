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
     * @param Request $request
     */
    public function __construct(
        string $pattern,
        \Closure $function,
        string $method = 'GET',
        Request $request = null
    ) {
        $this->pattern = $pattern;
        $this->function = $function;
        $this->method = $method;
        $this->request = $request ?: Request::populateFromGlobals();
        $this->response = new HttpResponse();
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
        $result = $fun($this->request, $this->response);
        $this->response->setPayload($result);
        return $this->response;
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
            && ($method == '*' || $method == $this->method);
    }
}
