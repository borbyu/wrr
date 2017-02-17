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
    public function setData($data)
    {
        $this->json = json_encode($data);
        return $this;
    }

    /**
     * @return mixed
     */
    public function decodeData()
    {
        return json_decode($this->json);
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function deliverPayload()
    {
        $this->addHeader('Content-Type: application/json');
        $this->setPayload($this->json);
        return parent::deliverPayload();
    }
}
