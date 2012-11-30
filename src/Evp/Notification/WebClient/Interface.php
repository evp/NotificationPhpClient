<?php

interface Evp_Notification_WebClient_Interface
{

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
    public function get($uri, $method = 'GET');

}