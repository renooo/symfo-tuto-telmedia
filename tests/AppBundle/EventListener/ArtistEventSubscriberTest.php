<?php

namespace Tests\AppBundle\EventListener;

use AppBundle\Client\BandsInTownClient;
use AppBundle\Entity\Artist;
use AppBundle\Event\ArtistEvent;
use AppBundle\EventListener\ArtistEventSubscriber;
use GuzzleHttp\Client;

class ArtistEventSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function onCreateChecksTourDates()
    {
        $clientMock = $this
            ->getMockBuilder(BandsInTownClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['normalizeArtistName'])
            ->getMock();

        $clientMock
            ->expects($this->once())
            ->method('normalizeArtistName');

        $subscriber = new ArtistEventSubscriber($clientMock);
        $subscriber->onCreate(new ArtistEvent((new Artist())->setName('Machin')));
    }
}
