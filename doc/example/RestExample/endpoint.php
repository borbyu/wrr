<?php
/**
 * This file is part of the Wrr package.
 *
 * (c) Jason Woys <jason@woys.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Wrr\Response\JsonResponse;
use Wrr\Router;
use Wrr\Route\DefaultRoute;
use Wrr\Response\DefaultResponse;

require_once __DIR__ . '/../../../vendor/autoload.php';

/*
 * make a wildcard route that covers everything and will result in a sane default
 */
$router = new Router();
$router->registerRoute(
    new DefaultRoute(
        '^/',
        function () {
            return "Wrr!... You've been served! ";
        }
    )
); // catch all

include_once 'ApiController.php';
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

$router->registerControllerRoute($controller);

$defaultResponse = new DefaultResponse();
$router->registerHttpRoute(
    'wrr',
    'GET',
    function () {
        return ["Wrr status", "Wrr is Cool!"];
    }
);

try {
    $headers = ['X-Meta: Response Built by Wrr!'];
    $response = $router
        ->respond(200, $headers);
} catch (Exception $e) {
    $response = new \Wrr\Response\HttpResponse();
    $response
        ->setPayload($e->getMessage())
        ->setResponseCode($e->getCode() ? $e->getCode() : 500)
        ->deliverPayload();
}
