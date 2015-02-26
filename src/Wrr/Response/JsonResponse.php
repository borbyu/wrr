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
 *
 * @package Wrr
 * @author  borbyu
 */
class JsonResponse extends AbstractResponse
{
    /**
     * @var string
     */
    private $json;

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->json = json_encode($data);
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
    public function deliverPayLoad()
    {
        $this->addHeader('Content-Type: application/json');
        if ($this->json) {
            $this->addBodyFragment($this->json);
        } else {
            throw new \Exception("No JSON", 500);
        }
        return parent::deliverPayLoad();
    }
}
