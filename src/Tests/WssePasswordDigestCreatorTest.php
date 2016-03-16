<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 16/03/16
 * Time: 04:34 PM
 */

namespace Ku\WsseSoapClient\Tests;


use Ku\WsseSoapClient\Services\WssePasswordDigestCreator;

class WssePasswordDigestCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     * @param $nonce
     * @param $created
     */
    public function testCreatePublicKey($nonce, $created)
    {
        $digestCreator = new WssePasswordDigestCreator('yourKey');
        $this->assertNotEmpty($digestCreator->createPublicKey($nonce, $created));
    }

    public function provider()
    {
        return array(
            array('Nonce', new \DateTime('now')),
            array('Nonce2', new \DateTime('2016-03-15')),
        );
    }
}
