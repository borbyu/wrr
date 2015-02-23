# Wrr is a Request Router
========================

A lightweight, and super fast PHP 5.3+ Request Routing Library and nothing else

This can be used standalone but most likely it will be used as a building block for other apps

Usage:

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
            * @param Response $response
            * @return Response
            */
           public function route(Response $response)
           {
               $response->addBodyFragment("You are in Admin Land... be careful.");
               return $response;
           }

           /**
            * @param $toMatch
            * @return bool
            */
           public function matchesPattern($toMatch)
           {
               $regex = "@" . self::ADMIN_PATTERN . "@";
               return (bool) preg_match($regex, $toMatch);
    }
    $router->registerRoute(new AdminRoute());

    /*
     * making a custom route by extending default route
     */
    class HelloWorldRoute extends \Wrr\DefaultRoute {
        public function __construct() {
            parent::__construct('^/blog$', function() {
                ob_start();
                $myBlogApp::run();
                return ob_clean();
            }
        }
    }
    $router->registerRoute(new HelloWorldRouteRoute());

    try {
        $response = $router
            ->setUriBase('/YourURIBase')
            ->setRequest(\Wrr\Request::populateFromGlobals())
            ->route();

        /*
         * send payload to client
         */
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

# About
======

# Requirements:
Any flavor of PHP 5.3 or above should do
[optional] PHPUnit 3.5+ to execute the test suite (phpunit --version)

# Author
======

jason woys aka borbyu <jason@woys.org>
Copyright 2013 Jason Woys (all rights reserved)


# License
=======

The MIT License (MIT)

Copyright (c) 2013 Jason Woys

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
