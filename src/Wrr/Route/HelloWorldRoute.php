<?php
/**
 * This file is part of the Wrr package.
 *
 * (c) Jason Woys <jason@woys.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Wrr\Route;

/**
 * Class HelloWorldRoute
 * @package Wrr\Route
 */
class HelloWorldRoute extends HttpRoute
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $fun = function () {
            ob_start();
            echo '<h1>hello world!</h1>';
            return ob_get_clean();
        };
        parent::__construct('^/blog$', $fun);
    }
}
