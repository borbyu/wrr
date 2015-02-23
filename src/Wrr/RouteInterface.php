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
 * Interface RouteInterface
 *
 * @package Wrr
 * @author borbyu
 */
interface RouteInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function match(Request $request);

    /**
     * @return AbstractResponse
     */
    public function route();

}
