<?php

use AppBundle\Client\BandsInTownClient;

class BandsInTownClientTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @covers BandsInTownClient::__construct
     */
    public function createClient()
    {
        $handler = new \GuzzleHttp\Handler\MockHandler([]);
        $guzzle = new \GuzzleHttp\Client(['handler' => $handler]);
        $client = new BandsInTownClient($guzzle, 12345);
        $this->assertInstanceOf(BandsInTownClient::class, $client);
    }
}
