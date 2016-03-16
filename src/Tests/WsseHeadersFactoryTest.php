<?php

namespace Ku\WsseSoapClient\Tests;

use Ku\WsseSoapClient\Services\WsseHeadersFactory;
use Prophecy\Argument;

/**
 *
 * Class WsseHeadersFactoryTest
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 */
class WsseHeadersFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var WsseHeadersFactory $factory
     */
    private $factory;

    /**
     *
     * @var string $nonce
     */
    private $nonce;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $namespace;


    /**
     *
     * test the creation of header
     * @dataProvider headerDataProvider
     *
     * @param $name
     * @param $value
     * @return SoapHeader
     */
    public function testCreateHeader($name, $value)
    {
        $header = $this->invokeMethod($this->factory, 'createHeader', [$name, $value]);
        $this->assertInstanceOf('SoapHeader', $header);
    }

    /**
     *
     *
     */
    public function testGetHeaders()
    {
        $headers = $this->factory->getHeaders($this->nonce);
        $this->assertNotEmpty($headers);;
        $this->assertEquals(count($headers), 4);
        $this->assertContainsOnlyInstancesOf('SoapHeader', $headers);
    }

    /**
     * init the test attributes
     */
    public function setUp() {
        $this->namespace = 'https://localhost/';
        $this->username = 'YourUsername';
        $this->nonce = 'nonce';
        $privatePassword = 'YourPassword';
        $digestCreator = $this->getDigestCreatorMock(new \DateTime('2016-03-15'), $privatePassword);
        $this->factory = new WsseHeadersFactory($this->namespace, $this->username, $digestCreator);
    }


    /**
     * @param \DateTime $created
     * @param $privateKey
     * @return Mock
     */
    private function getDigestCreatorMock(\DateTime $created, $privateKey) {
        $prophet = new \Prophecy\Prophet;
        $digestCreator = $prophet->prophesize('Ku\WsseSoapClient\Services\WssePasswordDigestCreator');
        $digestCreator->createPublicKey(Argument::type('string'), Argument::type('\DateTime'))
            ->willReturn(base64_encode(sha1($this->nonce . $created->format('Ymdhis') . $privateKey)))
            ->shouldBeCalled()
        ;
        return $digestCreator->reveal();
    }

    /**
     * @return array
     */
    public function headerDataProvider()
    {
        return array(
            array('Username', $this->username),
            array('Nonce', $this->nonce)
        );
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
