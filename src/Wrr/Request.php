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
 * Class Request
 * @package Wrr
 */
class Request
{
    /**
     * @var string
     */
    private $requestTime;

    /**
     * @var string
     */
    private $requestUri;

    /**
     * @var string
     */
    private $requestMethod;

    /**
     * @var string
     */
    private $remoteAddr;

    /**
     * @var string
     */
    private $queryString;

    /**
     * @var string
     */
    private $requestEndPoint;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * @var string
     */
    private $uriBase;

    /**
     * @var array
     */
    private $requestVars = [
        'json' => [],
        'get' => [],
        'post' => [],
        'cookie' => [],
        'files' => []
    ];

    /**
     * @var string
     */
    private $requestBody = '';

    /**
     * @var array
     */
    private $requestHeaders = [];

    /**
     * @param string $requestUri
     */
    public function __construct($requestUri = null)
    {
        if ($requestUri) {
            $this->setRequestUri($requestUri);
        }
    }

    /**
     * Get a populated request object from PHP Super Globals
     * ($_SERVER, $_GET, $_POST, $_COOKIES, and $_FILES)
     *
     * @return Request
     */
    public static function populateFromGlobals() : Request
    {
        $request = new Request();
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
            $request->setRequestHeaders($headers);
        } else {
            $headers = [];
        }
        $body = file_get_contents('php://input');
        $request->setRequestBody($body);
        if (in_array('Content-Type: application/json', $headers)) {
            $data = json_decode($body, true);
            foreach ($data as $key => $item) {
                $request->setRequestVar('json', $key, $item);
            }
        }
        if (isset($_SERVER)) {
            $request->setUserAgent($_SERVER['HTTP_USER_AGENT']);
            $request->setQueryString($_SERVER['QUERY_STRING']);
            $request->setRemoteAddr($_SERVER['REMOTE_ADDR']);
            $request->setRequestMethod($_SERVER['REQUEST_METHOD']);
            $request->setRequestUri($_SERVER['REQUEST_URI']);
            $request->setRequestTime($_SERVER['REQUEST_TIME']);
            $request->setRequestEndPoint($_SERVER['SCRIPT_NAME']);
        }
        $supersSet = ['get'=> $_GET, 'post' => $_POST, 'cookie' => $_COOKIE, 'files' => $_FILES];
        foreach ($supersSet as $container => $supers) {
            if (isset($supers) && is_array($supers)) {
                foreach ($supers as $key => $value) {
                    $request->setRequestVar($container, $key, $value);
                }
            }
        }

        return $request;
    }

    /**
     * @param string $container
     * @param string $key
     * @param mixed $value
     * @return Request
     */
    public function setRequestVar($container, $key, $value) : Request
    {
        if (!isset($this->requestVars[$container])) {
            $this->requestVars[$container] = [];
        }
        $this->requestVars[$container][$key] = $value;
        return $this;
    }

    /**
     * @param string $requestBody
     */
    public function setRequestBody($requestBody)
    {
        $this->requestBody = $requestBody;
    }

    /**
     * @return string
     */
    public function getRequestBody()
    {
        return $this->requestBody;
    }

    /**
     * @param array $requestHeaders
     */
    public function setRequestHeaders(array $requestHeaders)
    {
        $this->requestHeaders = $requestHeaders;
    }

    /**
     * @return array
     */
    public function getRequestHeaders() : array
    {
        return $this->requestHeaders;
    }

    /**
     * @param array $requestVars
     */
    public function setRequestVars(array $requestVars)
    {
        $this->requestVars = $requestVars;
    }

    /**
     * @return array
     */
    public function getRequestVars() : array
    {
        return $this->requestVars;
    }

    /**
     * @param string $key
     * @param null|string $container
     * @return mixed
     */
    public function getRequestVar($key, $container = null)
    {
        if (is_null($container)) {
            foreach ($this->requestVars as $container) {
                if (isset($container[$key])) {
                    return $container[$key];
                }
            }
            return null;
        } else {
            if (isset($this->requestVars[$container][$key])) {
                return $this->requestVars[$container][$key];
            }
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * @return mixed
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * @return mixed
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * @return mixed
     */
    public function getRemoteAddr()
    {
        return $this->remoteAddr;
    }

    /**
     * @return mixed
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @return mixed
     */
    public function getRequestEndPoint()
    {
        return $this->requestEndPoint;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param $requestTime
     */
    public function setRequestTime($requestTime)
    {
        $this->requestTime = $requestTime;
    }

    /**
     * @param $requestUri
     */
    public function setRequestUri($requestUri)
    {
        $this->requestUri = $requestUri;
    }

    /**
     * @param $requestMethod
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @param $remoteAddr
     */
    public function setRemoteAddr($remoteAddr)
    {
        $this->remoteAddr = $remoteAddr;
    }

    /**
     * @param $queryString
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;
    }

    /**
     * @param $requestEndPoint
     */
    public function setRequestEndPoint($requestEndPoint)
    {
        $this->requestEndPoint = $requestEndPoint;
    }

    /**
     * @param $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @param string $uriBase
     */
    public function setUriBase($uriBase)
    {
        $this->uriBase = $uriBase;
    }

    /**
     * @return string
     */
    public function getUriBase()
    {
        return $this->uriBase;
    }

    /**
     * @return string
     */
    public function getRelativeUri()
    {
        return str_replace($this->getUriBase(), "", $this->getRequestUri());
    }
}
