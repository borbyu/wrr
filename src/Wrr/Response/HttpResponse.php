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
 * Class HttpResponse
 * @package Wrr\Response
 */
class HttpResponse implements ResponseInterface
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var string
     */
    private $payload = '';

    /**
     * @var int
     */
    private $responseCode = 200;

    /**
     * @param array|string $header
     * @return $this
     */
    public function addHeader($header)
    {
        if (is_array($header)) {
            array_merge($this->headers, $header);
        } else {
            $this->headers[] = $header;
        }
        return $this;
    }

    /**
     * @param $payload
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Append headers and body together and
     * deliver the payload.
     *
     * @return $this
     */
    public function deliverPayload()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " " . $this->responseCode);
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->payload;
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
