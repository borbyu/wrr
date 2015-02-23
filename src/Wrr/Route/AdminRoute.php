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
 * Class AdminRoute
 *
 * @author borbyu
 */
class AdminRoute implements \Wrr\RouteInterface {
    /**
     * regex constant
     */
    const ADMIN_PATTERN = 'admin|root';

    /**
     * @var AbstractResponse
     */
    private $response;

    /**
     * @param \Wrr\AbstractResponse $response
     */
    public function __construct(\Wrr\AbstractResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @return \Wrr\AbstractResponse
     */
    public function route()
    {
        $this->response->addBodyFragment("You are in Admin Land... be careful.");
        return $this->response;
    }

    /**
     * @param $toMatch
     * @return bool
     */
    public function match(Request $request)
    {
        $regex = "@" . self::ADMIN_PATTERN . "@";
        return (bool) preg_match($regex, $request->getRelativeUri());
    }
}
