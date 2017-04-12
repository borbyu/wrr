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
     * @return ResponseInterface
     */
    public function addHeader($header) : ResponseInterface
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
     * @return ResponseInterface
     */
    public function setPayload($payload) : ResponseInterface
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Append headers and body together and
     * deliver the payload.
     *
     * @return ResponseInterface
     */
    public function deliverPayload() : ResponseInterface
    {
        header($_SERVER["SERVER_PROTOCOL"] . " " . $this->responseCode);
        foreach ($this->headers as $header) {
            header($header);
        }
        if (is_string($this->payload)) {
            echo $this->payload;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPayload() : string
    {
        return $this->payload;
    }

    /**
     * @param int $code
     * @return ResponseInterface
     */
    public function setResponseCode(int $code) : ResponseInterface
    {
        $this->responseCode = $code ?: 200;
        return $this;
    }

    /**
     * @return int
     */
    public function getResponseCode() : int
    {
        return $this->responseCode;
    }
}
