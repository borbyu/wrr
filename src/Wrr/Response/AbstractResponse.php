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
 * Class AbstractResponse
 *
 * @package Wrr
 * @author  borbyu
 */
abstract class AbstractResponse
{
    /**
     * @var array
     */
    private $headers = array();

    /**
     * @var array
     */
    private $body = array();

    /**
     * @var int
     */
    private $responseCode = 200;

    /**
     * @param $header
     * @return $this
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
        return $this;
    }

    /**
     * @param $bodyFragment
     * @return $this
     */
    public function addBodyFragment($bodyFragment)
    {
        $this->body [] = $bodyFragment;
        return $this;
    }

    /**
     * Append headers and body together and
     * deliver the payload.
     *
     * @return $this
     */
    public function deliverPayLoad()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " " . $this->responseCode);
        foreach ($this->headers as $header) {
            header($header);
        }
        foreach ($this->body as $bodyFragments) {
            echo $bodyFragments;
        }
        return $this;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setResponseCode($code)
    {
        $this->responseCode = $code;
        return $this;
    }
}
