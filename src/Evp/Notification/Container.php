<?php

class Evp_Notification_Container
{
    /**
     * @var array
     */
    private $values = array();

    /**
     * Creates instance of self. Can be used for fluent interface:
     *     Evp_Notification_Container::create($params)->getRequestParser()->parseRequest($_POST);
     *
     * @param array $params
     *
     * @return Evp_Notification_Container
     */
    public static function create(array $params = array())
    {
        return new self($params);
    }

    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $this->values = $params + array(
            'cache.filePath' => null,         // provide file path to cache file if you want to use cache for public key
            'webClient.useSocket' => false,   // if you want to force using sockets, pass true (curl is used if available)
            'webClient.timeout' => 15,        // timeout for web client
            'publicKey.uri' => 'http://downloads.webtopay.com/download/public.key',

                                                    // services; if null is provided, default one is created
            'requestParser' => null,
            'publicKeyProvider' => null,
            'util' => null,
            'signChecker' => null,
            'webClient' => null,
            'cache' => null,
                                                    // service factories (each one is callable);
            'requestParser.factory' => array($this, 'createRequestParser'),
            'publicKeyProvider.factory' => array($this, 'createPublicKeyProvider'),
            'util.factory' => array($this, 'createUtil'),
            'signChecker.factory' => array($this, 'createSignChecker'),
            'webClient.factory' => array($this, 'createWebClient'),
            'cache.factory' => array($this, 'createCache'),
        );
    }

    /**
     * @return Evp_Notification_RequestParser
     */
    public function getRequestParser()
    {
        return $this->getService('requestParser');
    }

    /**
     * @return Iterator
     */
    protected function getPublicKeyProvider()
    {
        return $this->getService('publicKeyProvider');
    }

    /**
     * @return Evp_Notification_Util
     */
    protected function getUtil()
    {
        return $this->getService('util');
    }

    /**
     * @return Evp_Notification_SignChecker
     */
    protected function getSignChecker()
    {
        return $this->getService('signChecker');
    }

    /**
     * @return Evp_Notification_WebClient_Interface
     */
    protected function getWebClient()
    {
        return $this->getService('webClient');
    }

    /**
     * @return Evp_Notification_PublicKeyProvider_Iterator_CacheInterface
     */
    protected function getCache()
    {
        return $this->getService('cache');
    }

    /**
     * @param string   $key
     *
     * @return mixed
     */
    protected function getService($key)
    {
        if (!isset($this->values[$key])) {
            $this->values[$key] = call_user_func($this->values[$key . '.factory']);
        }
        return $this->values[$key];
    }

    /**
     * @return Evp_Notification_RequestParser
     */
    protected function createRequestParser()
    {
        return new Evp_Notification_RequestParser($this->getSignChecker(), $this->getUtil());
    }

    /**
     * @return Evp_Notification_Util
     */
    protected function createUtil()
    {
        return new Evp_Notification_Util();
    }

    /**
     * @return Evp_Notification_SignChecker
     */
    protected function createSignChecker()
    {
        return new Evp_Notification_SignChecker($this->getPublicKeyProvider(), $this->getUtil());
    }

    /**
     * @return Iterator
     */
    protected function createPublicKeyProvider()
    {
        $remoteProvider = new Evp_Notification_PublicKeyProvider_Iterator_CallbackIterator(array(
            new Evp_Notification_PublicKeyProvider_Remote($this->getWebClient(), $this->values['publicKey.uri']),
            'getPublicKey',
        ));

        if (isset($this->values['cache']) || isset($this->values['cache.filePath'])) {
            return new Evp_Notification_PublicKeyProvider_Iterator_CachedValueIterator(
                $remoteProvider,
                $this->getCache()
            );
        } else {
            return $remoteProvider;
        }
    }

    /**
     * @return Evp_Notification_WebClient_Interface
     */
    protected function createWebClient()
    {
        if (function_exists('curl_init') && !$this->values['webClient.useSocket']) {
            return new Evp_Notification_WebClient_Curl($this->values['webClient.timeout']);
        } else {
            return new Evp_Notification_WebClient_Socket($this->values['webClient.timeout']);
        }
    }

    /**
     * @return Evp_Notification_PublicKeyProvider_Iterator_CacheInterface
     */
    protected function createCache()
    {
        return new Evp_Notification_PublicKeyProvider_Cache($this->values['cache.filePath']);
    }

}