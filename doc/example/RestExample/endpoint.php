<?php
/**
 * This file is part of the Wrr package.
 *
 * (c) Jason Woys <jason@woys.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Wrr\JsonResponse;
use Wrr\Router;
use Wrr\DefaultRoute;
use Wrr\DefaultResponse;

require_once __DIR__ . '/../../../vendor/autoload.php';

/*
 * make a wildcard route that covers everything and will result in a sane default
 */
$router = new Router();
$router->registerRoute(
    new DefaultRoute(
        '^/',                                                   
        function () { return "Wrr!... You've been served! "; }  
    )
); // catch all

include_once 'RestController.php';
$controller = new RestController($router, \Wrr\Request::populateFromGlobals());
$jsonResponse = new JsonResponse();
$router->registerRoute(
	new \Wrr\RestRoute(
        'rest',                                                 
        function () use ($controller) { 
        	return $controller->dispatch();
        },
        "GET",
        $jsonResponse
    )
);

$defaultResponse = new DefaultResponse();
$router->registerRoute(
	new \Wrr\RestRoute(
		'rest',
		function () {
			return array("Brocks status", "Brock is Cool!");
		},
		"POST",
		$jsonResponse 
	)
);

try {
    $response = $router
        ->setRequest(\Wrr\Request::populateFromGlobals())
        ->route();
    $response
        ->addHeader('X-Meta: Response Built by Wrr!')
        ->deliverPayload();

} catch (Exception $e) {
    $response = new \Wrr\DefaultResponse();
    $response
        ->addBodyFragment($e->getMessage())
        ->setResponseCode($e->getCode() ? $e->getCode() : 500)
        ->deliverPayLoad();
}
