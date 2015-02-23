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
 * Class RouteInterface
 * @package Wrr
 */
interface RouteInterface
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function match(Request $request);

    /**
     * @param string $pattern
     * @param string $method
     * @return bool
     */
    public function matchesPattern($pattern, $method);

    /**
     * @return AbstractResponse
     */
    public function route();

    /**
     * @param AbstractResponse $response
     * @return void
     */
    public function setResponse(AbstractResponse $response);
}
