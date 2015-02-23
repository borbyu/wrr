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
     * @var \Wrr\Response
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
	)
    {
        $this->pattern = $pattern;
        $this->function = $function;
        $this->method = $method;
        $this->setResponse($response);
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
            $result = $fun();
            if (is_scalar($result)) {
	            $this->response->addBodyFragment($result);
            } else if (method_exists($this->response, 'setData')) {
            	$this->response->setData($result);
            }
            else {
            	throw new \Exception('No Result to Route', 500);
            }
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
     * @param string $method
     * @return bool
     */
    public function matchesPattern($toMatch, $method)
    {
        $regex = "@" . $this->pattern . "@";
        return (bool) preg_match($regex, $toMatch) && $method == $this->method;
    }
    
    public function setResponse(AbstractResponse $response)
    {
    	$this->response = $response;	
    }
}
