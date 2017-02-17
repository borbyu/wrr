<?php
/**
 * This file is part of the Wrr package.
 *
 * (c) Jason Woys <jason@woys.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Wrr\Response;

/**
 * Class DefaultResponse
 * @package Wrr\Response
 */
class DefaultResponse extends HttpResponse
{
    /**
     * @return $this
     */
    public function deliverPayload()
    {
        return parent::deliverPayload();
    }
}
