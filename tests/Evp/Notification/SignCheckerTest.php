<?php

/**
 * Test for class Evp_Notifications_SignChecker
 */
class Evp_Notification_SignCheckerTest extends PHPUnit_Framework_TestCase
{

    /**
     * Randomly generated private and public keys pair
     *
     * @var string
     */
    protected static $privateKey = '-----BEGIN RSA PRIVATE KEY-----
MIIEpQIBAAKCAQEAv0W1m/xjqMcRmwmiJ4M25J1CVMVr36MWC60jlk821nOcpkZP
Lse29IDyITBfmBqdL9TP1kDFSfWoHzIBzW7lZxj3J6aXuqHbNtEpdt3tqxEtRsi4
XPaYjnWQbGxXlZwPJkWuRvyqeTZAsfpJAGFIZlxlr5pAPER7NTwozR6kWfl8U96/
zIuV9PMIJiIg2rnUQaSN6wZi876aV5oqlq3Ha+p32K9wAxFAx1FsJzOZT77rsjp3
h6riIAuPnW5Ut/LbJ5c/H+X6bGg3ytkk8KB6WH/7s1IG3gHc08EcYjgZVeZrFKat
RYXs8frLsnQPBeuZmQBFxBFUd8L+5vOZo7AP9wIDAQABAoIBAQClZMP7lC0hHrIs
nBHplN78pLdc0jHLehxwEFE7glfq7KHCbf2+d9fOaUn2RPwEbM8LMzxdCjkPEStF
flpsp74afk4JrVZ6fccvCYKPVKxVRk8ebCZvzJRya1ptRuodZor7Dzn6DDXlBnK+
86v4dibCzJbpV7q/4n+fstudMyfu2/xi7pIFTE1HiWHXsnZSank77oKIo6H/Seel
xwg3u1tapJPInRIBZTmegTJpKWQaegCpQCFEMGBgeRw9eKHXw8yZ0mdwJkLPuoUv
/tmyWIBGDWDUCMvlZiuAXGDXdhQt4ETBwgoHgC/7atxzqg/WPK25jR2lYl59zPDt
tN8EIqrBAoGBAN1XGFpGXPkd3WBLp1i+IWGVjdjf2ylUoQhA6JcTWQ1YSdVbJH2Q
yUAsoF8iu6YbZ4bZFRdPT+DIiDQ93DnqCW1Y0UV7mQ6VN0fQJvC6TS18wOBvbkPO
khEPqZKNPo1B88RJb6ZrxIbHr+wXgTpJm249AC5iy5Qi81WGjIjASx5xAoGBAN05
Rsa4gRahJzHopQ4lLMhBtu115U+r1j76s22ptmozSRzxM7IQBczRdzcXOcIOUpdi
DiLYdk5E3iA/SRtfKlLwpi9nuUekkokrnoJypky/WhEYPpRnZhtL7h4cdnRTY0/q
WFthxdi1r57lW0Ztfdcb8vn6hSF2mD+FueJmXRjnAoGAfdl6mEGvtVlcuNbrNNMO
SdzuBSTrCOn8kaPOW6/9j0/m0y/6ZIbBVwLIwK8QANdOGuctTc6jvUxn3URbBnbi
m1DH1Hj9QsRm5SceLPvQzA9F35acHGPEu3yrTw+ORGT+hFm46OgXmwbJKTUIHish
/CElDDrSQ81HjBZvq4WicJECgYEAncKKxowtAoZJ/T1692trVCQI366DqR1R2/fM
nRe6DmIkcY9Q3lquyDFYYuEdP1YXb/1tN0xGkepqvXRkHjDvbdZPrN67MmwaU9fX
Yg+AqJqNEEPJ3Osf1beAR9jkYHBXElZ8TC6deL2YUCgfv0m1xAEadUpCRmrch/BF
bz6whWECgYEAy0Fxp8CoQmbhWa1tiUHXKXzSk0zopfgAnnBIwGOXDRlCUO4Rtr0L
VA2Uhvw+6er+p32vvYfhyt3K7HSkCSVhpnxuTqoT8OJEXhmOwlAyvvjbs8Iqqeha
Uon3d0SR2JQoVzcsUNp2MrbZK1n4LoMqr4jWN91gNk+HDHvhfwyJFMY=
-----END RSA PRIVATE KEY-----';

    /**
     * @var string
     */
    protected static $publicKey = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAv0W1m/xjqMcRmwmiJ4M2
5J1CVMVr36MWC60jlk821nOcpkZPLse29IDyITBfmBqdL9TP1kDFSfWoHzIBzW7l
Zxj3J6aXuqHbNtEpdt3tqxEtRsi4XPaYjnWQbGxXlZwPJkWuRvyqeTZAsfpJAGFI
Zlxlr5pAPER7NTwozR6kWfl8U96/zIuV9PMIJiIg2rnUQaSN6wZi876aV5oqlq3H
a+p32K9wAxFAx1FsJzOZT77rsjp3h6riIAuPnW5Ut/LbJ5c/H+X6bGg3ytkk8KB6
WH/7s1IG3gHc08EcYjgZVeZrFKatRYXs8frLsnQPBeuZmQBFxBFUd8L+5vOZo7AP
9wIDAQAB
-----END PUBLIC KEY-----';

    /**
     * @var string
     */
    protected static $wrongPublicKey = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxitHf6MzQkqfQzhV9lmn
A1tPyAd7/YcwFuiU79B2XfYqqlX/eEqVn4Zcqo9TJL68q7gydimGzT2uUIO7ksnn
Wa+Z4Lv2Ibq7dCAON3AHKstMrfWx4uRspFah8Ryarx9Z4I3JCXJvvic5dAsA4AOb
x315rkf+WB31dhzrY0OY5RfI+RWwSiC31VMJC4wUiwihcl2dgxn+ZsyivlY1y8Cv
Wn7mgqRJIr40DNxLOXJAw0g/emRw9BZgsOhboydTRQS4lTICDwVaz8TuuKzAPuRe
ZU2buGuiM+B8/2iIF2iEPmbmiBrIrZCczQ3J8RXSrKGtiXBjDneOnvXF4LLt38Bs
HwIDAQAB
-----END PUBLIC KEY-----
';

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $util;

    /**
     * Sets up this test
     */
    public function setUp() {
        $this->util = $this->getMock('Evp_Notification_Util', array('decodeSafeUrlBase64'));
    }

    /**
     * Tests checkSign
     */
    public function testCheckSign() {
        $signChecker = new Evp_Notification_SignChecker(new ArrayIterator(array(self::$publicKey)), $this->util);

        $sign = null;
        $privateKey = openssl_pkey_get_private(self::$privateKey);
        openssl_sign('encodedData', $sign, $privateKey);

        $this->util
            ->expects($this->once())
            ->method('decodeSafeUrlBase64')
            ->with('encoded-sign')
            ->will($this->returnValue($sign));

        $this->assertTrue($signChecker->checkSign('encodedData', 'encoded-sign'));
    }

    /**
     * Tests checkSign with incorrect sign
     */
    public function testCheckSignWithBadSignature() {
        $signChecker = new Evp_Notification_SignChecker(new ArrayIterator(array(self::$publicKey)), $this->util);

        $this->util
            ->expects($this->once())
            ->method('decodeSafeUrlBase64')
            ->with('encoded-sign')
            ->will($this->returnValue('bad-sign'));

        $this->assertFalse($signChecker->checkSign('encodedData', 'encoded-sign'));
    }

    /**
     * Tests checkSign with more than one public key
     */
    public function testCheckSignWithSeveralKeys() {
        $signChecker = new Evp_Notification_SignChecker(
            new ArrayIterator(array('', self::$wrongPublicKey, self::$publicKey)),
            $this->util
        );

        $sign = null;
        $privateKey = openssl_pkey_get_private(self::$privateKey);
        openssl_sign('encodedData', $sign, $privateKey);

        $this->util
            ->expects($this->once())
            ->method('decodeSafeUrlBase64')
            ->with('encoded-sign')
            ->will($this->returnValue($sign));

        $this->assertTrue($signChecker->checkSign('encodedData', 'encoded-sign'));
    }

    /**
     * Tests checkSign with pair of wrong public keys
     */
    public function testCheckSignWithWrongPublicKey() {
        $signChecker = new Evp_Notification_SignChecker(
            new ArrayIterator(array('', self::$wrongPublicKey)),
            $this->util
        );

        $sign = null;
        $privateKey = openssl_pkey_get_private(self::$privateKey);
        openssl_sign('encodedData', $sign, $privateKey);

        $this->util
            ->expects($this->once())
            ->method('decodeSafeUrlBase64')
            ->with('encoded-sign')
            ->will($this->returnValue($sign));

        $this->assertFalse($signChecker->checkSign('encodedData', 'encoded-sign'));
    }
}