<?php

namespace Ku\WsseSoapClient;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class WsseHeadersFactory
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $username;

    /**
     * @var WssePasswordDigestCreator
     */
    private $passwordDigestCreator;

    /**
     * WsseHeadersFactory constructor.
     * @param string $namespace
     * @param string $username
     * @param WssePasswordDigestCreator $passwordDigestCreator
     */
    public function __construct($namespace, $username, WssePasswordDigestCreator $passwordDigestCreator)
    {
        $this->namespace = $namespace;
        $this->username = $username;
        $this->passwordDigestCreator = $passwordDigestCreator;
    }

    /**
     * @param $nonce
     * @return \SoapHeader[]|array
     */
    public function getHeaders($nonce)
    {
        $created = new \DateTime('now');
        $publicKey = $this->passwordDigestCreator->createPublicKey($nonce, $created);

        return [
            $this->createHeader('Username', $this->username),
            $this->createHeader('Nonce', $nonce),
            $this->createHeader('Created', $created->format('Ymdhis')),
            $this->createHeader('PasswordDigest', $publicKey),
        ];
    }

    /**
     * @param $name
     * @param $value
     * @return \SoapHeader
     */
    protected function createHeader($name, $value)
    {
        return new \SoapHeader($this->namespace, $name, $value);
    }
}