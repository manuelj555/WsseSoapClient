<?php

namespace Ku\WsseSoapClient;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class WssePasswordDigestCreator
{
    /**
     * @var string
     */
    private $privateKey;

    /**
     * WssePasswordDigestCreator constructor.
     * @param string $privateKey
     */
    public function __construct($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @param $nonce
     * @param \DateTime $created
     * @return string
     */
    public function createPublicKey($nonce, \DateTime $created)
    {
        return base64_encode(sha1($nonce.$created->format('Ymdhis').$this->privateKey));
    }
}