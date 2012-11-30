<?php

/**
 * Web client implementation using sockets
 */
class Evp_Notification_WebClient_Socket implements Evp_Notification_WebClient_Interface
{
    /**
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
        $url = parse_url($uri);
        if ('https' == $url['scheme']) {
            $host = 'ssl://' . $url['host'];
            $port = 443;
        } else {
            $host = $url['host'];
            $port = 80;
        }

        $fp = fsockopen($host, $port, $errNo, $errStr, $this->timeout);
        if (!$fp) {
            if (!$errNo) {
                throw new Evp_Notification_Exception_WebClientException('Error initializing the socket: ' . $errStr);
            } else {
                throw new Evp_Notification_Exception_WebClientException(
                    sprintf('Cannot connect to %s. Error code: %d, error message: %s', $uri, $errNo, $errStr)
                );
            }
        }

        if (isset($url['query'])) {
            $data = $url['path'] . '?' . $url['query'];
        } else {
            $data = $url['path'];
        }

        $out = $method . ' ' . $data . " HTTP/1.0\r\n";
        $out .= 'Host: ' . $url['host'] . "\r\n";
        $out .= "Connection: Close\r\n\r\n";

        fwrite($fp, $out);

        $content = '';
        while (!feof($fp)) {
            $content .= fgets($fp, 8192);
        }
        fclose($fp);

        list($headers, $content) = explode("\r\n\r\n", $content, 2);
        $headers = explode("\r\n", $headers);

        $statusHeader = reset($headers);                        // First line of headers - status line
        $statusHeaderParts = explode(' ', $statusHeader, 3);    // HTTP/1.1 200 OK
        $statusCode = intval($statusHeaderParts[1]);            // Second part - status code

        if ($statusCode !== 200) {
            throw new Evp_Notification_Exception_WebClientException(
                sprintf('Got status code not 200 (%d) after requesting %s', $statusCode, $uri)
            );
        }

        return $content;
    }

}