<?php

/**
 * Web client implementation using cURL library
 */
class Evp_Notification_WebClient_Curl implements Evp_Notification_WebClient_Interface
{
    /**
     * User agent
     *
     * @var string
     */
    protected $userAgent = 'Mozilla/5.0 (compatible; Evp-Notifications-Curl)';

    /**
     * Request timeout in seconds
     *
     * @var int
     */
    protected $timeout;

    /**
     * @param int $timeout
     */
    public function __construct($timeout = 15)
    {
        $this->timeout = $timeout;
    }

    /**
     * User agent setter
     *
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * Makes HTTP/S request to URI using specified method
     *
     * @param string $uri
     * @param string $method
     *
     * @return string
     *
     * @throws Evp_Notification_Exception_WebClientException
     */
    public function get($uri, $method = 'GET')
    {
        $curl = $this->getCurl();
        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));

        $result = curl_exec($curl);
        if ($result === false) {
            $exception = new Evp_Notification_Exception_WebClientException(sprintf(
                'Cannot connect to %s. Error code: %d, error message: %s',
                $uri,
                curl_errno($curl),
                curl_error($curl)
            ));
            curl_close($curl);
            throw $exception;
        }

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $parts = explode("\r\n\r\n", $result, 2);
        $content = isset($parts[1]) ? $parts[1] : '';

        curl_close($curl);

        if ($statusCode !== 200) {
            throw new Evp_Notification_Exception_WebClientException(
                sprintf('Got status code not 200 (%d) after requesting %s', $statusCode, $uri)
            );
        }

        return $content;
    }


    /**
     * Gets Curl handle
     *
     * @return resource a cURL handle
     *
     * @throws Evp_Notification_Exception_WebClientException
     */
    protected function getCurl()
    {
        if (!function_exists('curl_init')) {
            throw new Evp_Notification_Exception_WebClientException('Curl is not available on this system');
        }

        $curl = curl_init();
        if (!$curl) {
            throw new Evp_Notification_Exception_WebClientException('Error while initiating curl');
        }

        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 0);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);

        $this->setSslOptions($curl);

        if ($this->userAgent) {
            curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
        }
        return $curl;
    }

    /**
     * Sets SSL options to use in cURL
     *
     * @param resource $curl
     */
    protected function setSslOptions($curl)
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__) . '/../Resources/ca-bundle.crt');
    }

}