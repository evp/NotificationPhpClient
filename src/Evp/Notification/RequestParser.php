<?php

class Evp_Notification_RequestParser
{
    /**
     * @var Evp_Notification_SignChecker
     */
    protected $signChecker;

    /**
     * @var Evp_Notification_Util
     */
    protected $util;


    public function __construct(Evp_Notification_SignChecker $signChecker, Evp_Notification_Util $util)
    {
        $this->signChecker = $signChecker;
        $this->util = $util;
    }

    /**
     * @param array $request
     *
     * @return Evp_Notification_Entity_OperationNotification
     *
     * @throws Evp_Notification_Exception_InvalidParametersException
     * @throws Evp_Notification_Exception_InvalidSignException
     */
    public function parseRequest(array $request)
    {
        return Evp_Notification_Entity_OperationNotification::fromParams($this->parseRequestToArray($request));
    }


    /**
     * @param array $request
     *
     * @return array
     *
     * @throws Evp_Notification_Exception_InvalidParametersException
     * @throws Evp_Notification_Exception_InvalidSignException
     *
     * @see parseRequest
     */
    public function parseRequestToArray(array $request)
    {
        if (!isset($request['data']) || !isset($request['sign'])) {
            throw new Evp_Notification_Exception_InvalidParametersException('data or sign parameter not provided');
        }
        if (!is_scalar($request['data']) || !is_scalar($request['sign'])) {
            throw new Evp_Notification_Exception_InvalidParametersException('data or sign parameter is not scalar');
        }

        $encodedData = (string) $request['data'];
        $sign = (string) $request['sign'];

        if (!$this->signChecker->checkSign($encodedData, $sign)) {
            throw new Evp_Notification_Exception_InvalidSignException('Sign is not valid');
        }

        $queryString = $this->util->decodeSafeUrlBase64($encodedData);
        return $this->util->parseHttpQuery($queryString);
    }
}