<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\ArtistController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArtistControllerTest extends WebTestCase
{
    /**
     * @test
     * @covers ArtistController::indexAction
     */
    public function indexShowsAlphabeticalListOfArtist()
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/artists');
        $titles = $crawler->filter('.row .col-md-3:nth-child(2)');

        $this->assertEquals('!!!', $titles->first()->text());
        $this->assertEquals('Zwan', $titles->last()->text());
    }

    /**
     * @test
     */
    public function artistCreationIsUnavailableWhenAnonymous()
    {
        $client = self::createClient();
        $client->followRedirects(false);
        $crawler = $client->request('GET', '/artist/create');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function authenticatedUserCanCreateUser()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/login');

        $loginForm = $crawler->filter('form')->form([
            '_username' => 'toto',
            '_password' => 'azerty',
        ]);

        $client->submit($loginForm);
        $crawler = $client->request('GET', '/artist/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //$crawler = $client->click($crawler->selectLink('Retour à la liste')->link());
        //$this->assertContains('Liste des artistes', $crawler->filter('h1')->first()->text());

        $artistForm = $crawler->filter('form')->form([
            'artist_form[name]' => 'BB King',
            'artist_form[creationYear]' => '1999',
            'artist_form[genres]' => '75',
            'artist_form[biography]' => 'Bla bla bla bla bla bla bla bla bla bla bla bla.'
        ]);

        $client->followRedirects(true);
        $crawler = $client->submit($artistForm);
        $this->assertContains('BB King', $crawler->filter('h1')->first()->text(), '', true);
    }
}
