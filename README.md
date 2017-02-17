# Wrr is a Request Router
========================

A lightweight, and super fast PHP 7 Request Routing Library and nothing else

Usage:
```
    <?php
    require_once __DIR__ . '/vendor/autoload.php';

    $router = new \Wrr\Router();

    /*
     * make a wildcard route that covers everything and will result in a sane default
     */
    $router->registerRoute(
        new \Wrr\DefaultRoute(
            '^/',                                                   // regex to match to uri
            function () { return "Wrr!... You've been served! "; }  // closure to define response
        )
    );

    /*
     * making a custom defined route by implementing route interface
     * matches 'admin|root'
     */
    class AdminRoute implements \Wrr\RouteInterface {
        /**
         * regex constant
         */
        const ADMIN_PATTERN = 'admin|root';

        /**
         * @var \Wrr\Response\HttpResponse
         */
        private $response;

        /**
         * @param \Wrr\Response\HttpResponse $response
         */
        public function __construct(\Wrr\Response\HttpResponse $response)
        {
            $this->response = $response;
        }

        /**
         * @return \Wrr\Response\HttpResponse
         */
        public function route()
        {
            $this->response->setPayload("You are in Admin Land... be careful.");
            return $this->response;
        }

        /**
         * @param \Wrr\Request $request
         * @return bool
         */
        public function match(\Wrr\Request $request)
        {
            $regex = "@" . self::ADMIN_PATTERN . "@";
            return (bool) preg_match($regex, $request->getRelativeUri());
        }
    }
    $router->registerRoute(new AdminRoute());

    $controller = new \RestExample\ApiController(
        \Wrr\Request::populateFromGlobals(),
        new JsonResponse()
    );

    $jsonResponse = new JsonResponse();
    $router->registerHttpRoute(
        'rest',
        '*',
        function () use ($controller) {
            return $controller->dispatch();
        }
    );

    try {
        $response = $router->route();

        /* send payload to client */
        $response
            ->addHeader('X-Meta: Response Built by Wrr!')
            ->deliverPayload();

    } catch (Exception $e) {
        $response = new \Wrr\Response();
        $response
            ->addBodyFragment($e->getMessage())
            ->setResponseCode($e->getCode() ? $e->getCode() : 500)
            ->deliverPayLoad();
    }
```

# Requirements:
#### PHP 7+
#### PHPUnit 5.2+ to execute the test suite (phpunit --version)

# Author
======

#### borbyu <jason@woys.org>
#### Copyright 2017 Jason Woys (all rights reserved)
