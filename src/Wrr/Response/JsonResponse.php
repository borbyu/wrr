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
 * Class JsonResponse
 * @package Wrr\Response
 */
class JsonResponse extends HttpResponse
{
    /**
     * @var string
     */
    private $json = '';

    /**
     * @param $data
     * @return JsonResponse
     */
    public function setData($data) : JsonResponse
    {
        $this->json = json_encode($data);
        return $this;
    }

    /**
     * @param string $payload
     * @return ResponseInterface
     */
    public function setPayload($payload) : ResponseInterface
    {
        $this->setData($payload);
        return parent::setPayload($this->json);
    }

    /**
     * @return mixed
     */
    public function decodeData()
    {
        return json_decode($this->json);
    }

    /**
     * @return ResponseInterface
     * @throws \Exception
     */
    public function deliverPayload() : ResponseInterface
    {
        $this->addHeader('Content-Type: application/json');
        return parent::deliverPayload();
    }
}
