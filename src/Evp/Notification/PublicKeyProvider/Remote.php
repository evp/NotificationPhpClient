<?php

class Evp_Notification_PublicKeyProvider_Remote
{
    /**
     * @var Evp_Notification_WebClient_Interface
     */
    protected $webClient;

    /**
     * @var string
     */
    protected $publicKeyUri;


    public function __construct(Evp_Notification_WebClient_Interface $webClient, $publicKeyUri)
    {
        $this->webClient = $webClient;
        $this->publicKeyUri = $publicKeyUri;
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->webClient->get($this->publicKeyUri);
    }
}