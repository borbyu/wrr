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
    private $requestTime = '';

    /**
     * @var string
     */
    private $requestUri = '';

    /**
     * @var string
     */
    private $requestMethod = '';

    /**
     * @var string
     */
    private $remoteAddr = '';

    /**
     * @var string
     */
    private $queryString = '';

    /**
     * @var string
     */
    private $requestEndPoint = '';

    /**
     * @var string
     */
    private $userAgent = '';

    /**
     * @var string
     */
    private $uriBase = '';

    /**
     * @var array
     */
    private $requestVars = [];

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
        }
        $body = file_get_contents('php://input');
        $request->setRequestBody($body);

        $jsonData = json_decode($body, true);
        parse_str($body, $urlParsedData);
        $urlParsedData = $urlParsedData ?: [];
        $bodyData = $jsonData ?: $urlParsedData;

        foreach ($bodyData as $key => $item) {
            $request->setRequestVar('body', $key, $item);
        }

        $exists = function ($key) {
            return $_SERVER[$key] ?? '';
        };
        if (isset($_SERVER)) {
            $request->setUserAgent($exists('HTTP_USER_AGENT'));
            $request->setQueryString($exists('QUERY_STRING'));
            $request->setRemoteAddr($exists('REMOTE_ADDR'));
            $request->setRequestMethod($exists('REQUEST_METHOD'));
            $request->setRequestUri($exists('REQUEST_URI'));
            $request->setRequestTime($exists('REQUEST_TIME'));
            $request->setRequestEndPoint($exists('SCRIPT_NAME'));
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
    public function setRequestBody($requestBody) : void
    {
        $this->requestBody = $requestBody;
    }

    /**
     * @return string
     */
    public function getRequestBody() : ?string
    {
        return $this->requestBody;
    }

    /**
     * @param array $requestHeaders
     */
    public function setRequestHeaders(array $requestHeaders) : void
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
    public function setRequestVars(array $requestVars) : void
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
     * @param int $index
     * @return mixed
     */
    public function getUriVar($index) : ?string
    {
        $uriFragments = explode('/', $this->getRelativeUri());
        array_shift($uriFragments);
        $fragmentExists = isset($uriFragments[$index]);
        return $fragmentExists ? $uriFragments[$index] : null;
    }

    /**
     * @param string $key
     * @param null|string $bag
     * @return mixed
     */
    public function getRequestVar(string $key, ?string $bag = null) : ?string
    {
        if ($bag === null) {
            foreach ($this->requestVars as $varBag) {
                if (isset($varBag[$key])) {
                    return $varBag[$key];
                }
            }
            return null;
        }
        return $this->requestVars[$bag][$key] ?? null;
    }

    /**
     * @return string
     */
    public function getRequestTime() : ?string
    {
        return $this->requestTime;
    }

    /**
     * @return string
     */
    public function getRequestUri() : ?string
    {
        return $this->requestUri;
    }

    /**
     * @return string
     */
    public function getRequestMethod() : ?string
    {
        return $this->requestMethod;
    }

    /**
     * @return string
     */
    public function getRemoteAddr() : ?string
    {
        return $this->remoteAddr;
    }

    /**
     * @return string
     */
    public function getQueryString() : string
    {
        return $this->queryString;
    }

    /**
     * @return string
     */
    public function getRequestEndPoint() : string
    {
        return $this->requestEndPoint;
    }

    /**
     * @return string
     */
    public function getUserAgent() : string
    {
        return $this->userAgent;
    }

    /**
     * @param $requestTime
     */
    public function setRequestTime($requestTime) : void
    {
        $this->requestTime = $requestTime;
    }

    /**
     * @param $requestUri
     */
    public function setRequestUri($requestUri) : void
    {
        $this->requestUri = $requestUri;
    }

    /**
     * @param $requestMethod
     */
    public function setRequestMethod($requestMethod) : void
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @param $remoteAddr
     */
    public function setRemoteAddr($remoteAddr) : void
    {
        $this->remoteAddr = $remoteAddr;
    }

    /**
     * @param $queryString
     */
    public function setQueryString($queryString) : void
    {
        $this->queryString = $queryString;
    }

    /**
     * @param $requestEndPoint
     */
    public function setRequestEndPoint($requestEndPoint) : void
    {
        $this->requestEndPoint = $requestEndPoint;
    }

    /**
     * @param $userAgent
     */
    public function setUserAgent($userAgent) : void
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @param string $uriBase
     */
    public function setUriBase($uriBase) : void
    {
        $this->uriBase = $uriBase;
    }

    /**
     * @return string
     */
    public function getUriBase() : string
    {
        return $this->uriBase;
    }

    /**
     * @return string
     */
    public function getRelativeUri() : string
    {
        return str_replace($this->getUriBase(), '', $this->getRequestUri());
    }
}
