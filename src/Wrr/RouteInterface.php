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

use Wrr\Response\ResponseInterface;

/**
 * Interface RouteInterface
 * @package Wrr
 */
interface RouteInterface
{
    /**
     * @param Request $request
     * @return bool
     */
    public function match(Request $request) : bool;

    /**
     * @return ResponseInterface
     */
    public function route() : ResponseInterface;
}
