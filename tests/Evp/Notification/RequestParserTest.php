<?php

/**
 * Test for class Evp_Notification_RequestParser
 */
class Evp_Notification_RequestParserTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $signChecker;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $util;

    /**
     * @var Evp_Notification_RequestParser
     */
    protected $requestParser;

    /**
     * Sets up this test
     */
    public function setUp() {
        $this->signChecker = $this->getMockBuilder('Evp_Notification_SignChecker')
            ->setMethods(array('checkSign'))
            ->disableOriginalConstructor()
            ->getMock();
        $this->util = $this->getMock('Evp_Notification_Util', array('decodeSafeUrlBase64', 'parseHttpQuery'));
        $this->requestParser = new Evp_Notification_RequestParser($this->signChecker, $this->util);
    }

    /**
     * Exception should be thrown on invalid sign
     *
     * @expectedException Evp_Notification_Exception_InvalidSignException
     */
    public function testParseRequestToArrayWithInvalidSign() {
        $request = array('data' => 'abcdef', 'sign' => 'qwerty');

        $this->signChecker->expects($this->once())
            ->method('checkSign')
            ->with('abcdef', 'qwerty')
            ->will($this->returnValue(false));

        $this->util->expects($this->never())->method($this->anything());

        $this->requestParser->parseRequestToArray($request);
    }

    /**
     * Exception should be thrown on invalid parameters
     *
     * @expectedException Evp_Notification_Exception_InvalidParametersException
     */
    public function testParseRequestToArrayWithInvalidParameters() {
        $request = array('data' => 'abcdef');

        $this->signChecker->expects($this->never())->method($this->anything());
        $this->util->expects($this->never())->method($this->anything());

        $this->requestParser->parseRequestToArray($request);
    }

    /**
     * Exception should be thrown on invalid parameters
     *
     * @expectedException Evp_Notification_Exception_InvalidParametersException
     */
    public function testParseRequestToArrayWithArrayParameters() {
        $request = array('data' => 'abcdef', 'sign' => array('a' => 'b'));

        $this->signChecker->expects($this->never())->method($this->anything());
        $this->util->expects($this->never())->method($this->anything());

        $this->requestParser->parseRequestToArray($request);
    }

    /**
     * Tests parseRequestToArray with success scenario
     */
    public function testParseRequest() {
        $request = array('data' => 'abcdef', 'sign' => 'qwerty');
        $parsed = array('a' => 'b');

        $this->signChecker->expects($this->once())
            ->method('checkSign')
            ->with('abcdef', 'qwerty')
            ->will($this->returnValue(true));

        $this->util->expects($this->at(0))
            ->method('decodeSafeUrlBase64')
            ->with('abcdef')
            ->will($this->returnValue('zxc'));
        $this->util->expects($this->at(1))
            ->method('parseHttpQuery')
            ->with('zxc')
            ->will($this->returnValue($parsed));

        $this->assertSame($parsed, $this->requestParser->parseRequestToArray($request));
    }

}