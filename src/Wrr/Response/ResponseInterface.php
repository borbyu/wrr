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
 * Interface ResponseInterface
 * @package Wrr\Response
 */
interface ResponseInterface
{
    /**
     * @return ResponseInterface
     */
    public function deliverPayload();

    /**
     * @param string $payload
     * @return ResponseInterface
     */
    public function setPayload($payload);

    /**
     * @param $header
     * @return ResponseInterface
     */
    public function addHeader($header);

    /**
     * @param int $code
     * @return ResponseInterface
     */
    public function setResponseCode($code);
}
