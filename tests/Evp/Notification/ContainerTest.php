<?php

/**
 * Test for class Evp_Notification_Container
 */
class Evp_Notification_ContainerTest extends PHPUnit_Framework_TestCase
{

    /**
     * Tests getRequestParser
     */
    public function testGetRequestParser() {
        $container = new Evp_Notification_Container();

        $service = $container->getRequestParser();
        $this->assertSame($service, $container->getRequestParser());
        $this->assertSame($service, $container->getRequestParser());

        $this->assertInstanceOf('Evp_Notification_RequestParser', $service);
    }

    /**
     * Tests getRequestParser with custom service
     */
    public function testGetRequestParserWithCustomService() {
        $service = $this->getMockBuilder('Evp_Notification_RequestParser')->disableOriginalConstructor()->getMock();

        $container = new Evp_Notification_Container(array(
            'requestParser' => $service,
        ));

        $this->assertSame($service, $container->getRequestParser());
        $this->assertSame($service, $container->getRequestParser());
    }

    /**
     * Tests getRequestParser with custom service factory
     */
    public function testGetRequestParserWithCustomFactory() {
        $container = new Evp_Notification_Container(array(
            'requestParser.factory' => array($this, 'getRequestParser'),
        ));

        $service = $container->getRequestParser();
        $this->assertSame($service, $container->getRequestParser());

        $this->assertSame(array('param' => 'custom'), $service->parseRequest(array()));
    }

    public function getRequestParser()
    {
        $service = $this->getMockBuilder('Evp_Notification_RequestParser')
            ->setMethods(array('parseRequest'))
            ->disableOriginalConstructor()
            ->getMock();
        $service->expects($this->any())->method('parseRequest')->will($this->returnValue(array('param' => 'custom')));
        return $service;
    }
}
