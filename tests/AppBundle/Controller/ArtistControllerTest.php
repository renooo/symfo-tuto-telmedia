<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArtistControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function indexActionShowsArtistsInAlphabeticalOrder()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/artists');

        $cols = $crawler->filter('.row .col-md-3:nth-child(2)');
        $this->assertContains('!!!', $cols->first()->text());
        $this->assertContains('Zwan', $cols->last()->text());
    }
}
