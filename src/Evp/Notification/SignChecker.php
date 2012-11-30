<?php


class Evp_Notification_SignChecker
{
    /**
     * @var Evp_Notification_Util
     */
    protected $util;

    /**
     * @var Iterator
     */
    protected $publicKeyProvider;


    public function __construct(
        Iterator $publicKeyProvider,
        Evp_Notification_Util $util
    ) {
        $this->util = $util;
        $this->publicKeyProvider = $publicKeyProvider;
    }

    /**
     * Checks signature
     *
     * @param string $data
     * @param string $sign
     *
     * @return boolean
     */
    public function checkSign($data, $sign) {
        $decodedSign = $this->util->decodeSafeUrlBase64($sign);

        foreach ($this->publicKeyProvider as $publicKey) {
            $ok = @openssl_verify($data, $decodedSign, $publicKey);
            if ($ok === 1) {
                return true;
            }
        }
        return false;
    }
}