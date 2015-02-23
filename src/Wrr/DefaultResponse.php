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
 * Class DefaultResponse
 * @package Wrr
 */
class DefaultResponse extends AbstractResponse
{
    /**
     * @return $this
     */
    public function deliverPayLoad()
    {
        return parent::deliverPayload();
    }
}
