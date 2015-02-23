<?php

/**
 * Class RestController
 *
 * @author jwoys
 */
class RestController
{
    /**
     * @var Wrr\Request
     */
    private $request = null;
    private $router = null;

    /**
     * @param \Wrr\Request $request
     */
    public function __construct(Wrr\Router $router, Wrr\Request $request)
    {
        $this->request = $request;
        $this->router = $router;
    }

    public function dispatch()
    {
		return array("foo"=>"bar");               
    }  
}
