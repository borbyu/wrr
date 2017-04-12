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

use Wrr\Response\ResponseInterface;

/**
 * Class Controller
 * @package Wrr
 */
abstract class Controller
{
    /**
     * @var Request
     */
    private $request = null;

    /**
     * @var ResponseInterface
     */
    private $response = null;

    /**
     * Controller constructor.
     * @param Request $request
     * @param ResponseInterface $response
     */
    public function __construct(Request $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    abstract public function dispatch() : ResponseInterface;

    /**
     * @return Request
     */
    public function getRequest() : Request
    {
        return $this->request;
    }

    /**
     * @return ResponseInterface
     */
    protected function getResponse() : ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return '*';
    }
}
