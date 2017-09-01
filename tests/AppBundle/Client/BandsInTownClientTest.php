<?php

namespace Tests\AppBundle\Client;

use AppBundle\Client\BandsInTownClient;
use AppBundle\Entity\Artist;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class BandsInTownClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers BandsInTownClient::__construct
     */
    public function createClient()
    {
        $guzzle = new Client();
        $client = new BandsInTownClient($guzzle, 12345);

        $this->assertInstanceOf(BandsInTownClient::class, $client);
    }

    /**
     * @test
     * @covers BandsInTownClient::getTourDates
     */
    public function getTourDatesReturnsDatesForExistingArtist()
    {
        $queue = [
            new Response(
                HttpResponse::HTTP_OK,
                ['content-type' => 'application/json'],
                file_get_contents(__DIR__.'/data/events-aerosmith.json')
            ),
        ];

        $handler = new MockHandler($queue);
        $guzzle = new Client(['handler' => $handler]);
        $client = new BandsInTownClient($guzzle, 123);

        $artist = new Artist();
        $artist->setName('Aerosmith');
        $dates = $client->getTourDates($artist);

        $this->assertNotEmpty($dates);
        $this->assertContains('Belo Horizonte', $dates[1]->title);
    }

    /**
     * @test
     * @covers BandsInTownClient::getTourDates
     */
    public function getTourDatesReturnsEmptyArrayForNonExistingArtist()
    {
        $queue = [
            new Response(
                HttpResponse::HTTP_NOT_FOUND,
                ['content-type' => 'application/json'],
                file_get_contents(__DIR__.'/data/events-unknown.json')
            ),
        ];

        $handler = new MockHandler($queue);
        $guzzle = new Client(['handler' => $handler]);
        $client = new BandsInTownClient($guzzle, 123);

        $artist = new Artist();
        $artist->setName('Bidule');
        $dates = $client->getTourDates($artist);

        $this->assertEmpty($dates);
    }

    public function getTourDatesReturnsEmptyArrayForBlankArtistName()
    {
    }

    /**
     * @test
     * @dataProvider artistNameProvider
     */
    public function normalizeArtistNameLowersCase($name, $normalized)
    {
        $guzzle = new Client();
        $client = new BandsInTownClient($guzzle, 123);
        $result = $client->normalizeArtistName($name);

        $this->assertEquals($normalized, $result);
    }

    public function artistNameProvider()
    {
        return [
            ['TOTO', 'toto'],
            ['bidule', 'bidule'],
            ['MaChIn', 'machin'],
            [new \DateTime(), ''],
            [null, ''],
            [12345, ''],
            ['12345', '12345'],
        ];
    }
}
