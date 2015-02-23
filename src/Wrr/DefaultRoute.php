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
 * Class DefaultRoute
 * @package Wrr
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
     * @var AbstractResponse 
     */
	private $response;
    
    /**
     * @param string $pattern
     * @param \Closure $function
     */
    public function __construct($pattern, \Closure $function, $method = "GET")
    {
        $this->pattern = $pattern;
        $this->function = $function;
        $this->method = $method;
        $this->setResponse(new DefaultResponse());
    }

    /**
     * Do the routing and call the closure
     *
     * @param Response $response
     * @return Response
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
     */
    public function match(Request $request)
    {
        $pattern = str_replace($request->getUriBase(), "", $request->getRequestUri());
        return $this->matchesPattern($pattern);
    }

    /**
     * @param string $toMatch
     * @return bool
     */
    public function matchesPattern($toMatch, $method = "GET")
    {
        $regex = "@" . $this->pattern . "@";
        return (bool) preg_match($regex, $toMatch) && $method = $this->method;
    }
    
    public function setResponse(AbstractResponse $response)
    {
    	$this->response = $response;	
    }
}
