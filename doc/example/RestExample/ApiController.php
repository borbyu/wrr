<?php
/**
 * This file is part of the Wrr package.
 *
 * (c) Jason Woys <jason@woys.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RestExample;

use Wrr\Controller;
use Wrr\Request;
use Wrr\Response\JsonResponse;
use Wrr\Response\ResponseInterface;

/**
 * Class ApiController
 * @package RestExample
 */
class ApiController extends Controller
{
    /**
     * @param \Wrr\Request $request
     * @param JsonResponse $response
     */
    public function __construct(Request $request, JsonResponse $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * @return ResponseInterface
     */
    public function dispatch()
    {
        return ($this->getRequest()->getRequestMethod() == 'POST')
            ? $this->post()
            : $this->get();
    }

    /**
     * @param $responseCode
     * @return JsonResponse
     */
    public function get($responseCode = 200)
    {
        $data = ["status"=>"gotten"];
        return $this->respond($responseCode, $data);
    }

    /**
     * @param $responseCode
     * @return JsonResponse
     */
    public function post($responseCode = 200)
    {
        $data = ['status' => 'posted'];
        return $this->respond($responseCode, $data);
    }

    /**
     * @param $code
     * @param $data
     * @return JsonResponse
     */
    private function respond($code, $data)
    {
        return $this->getResponse()
            ->setResponseCode($code)
            ->setPayload($data)
            ->deliverPayload();
    }

    /**
     * @return JsonResponse
     */
    protected function getResponse()
    {
        return parent::getResponse();
    }
}
