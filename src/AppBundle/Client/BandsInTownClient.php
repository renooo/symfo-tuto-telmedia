<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 07/02/2017
 * Time: 16:00
 */

namespace AppBundle\Client;

use AppBundle\Entity\Artist;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class BandsInTownClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $appId;

    function __construct(Client $client, $appId)
    {
        $this->client = $client;
        $this->appId = $appId;
    }

    public function normalizeArtistName($artistName)
    {
        if (!is_string($artistName)) {
            return '';
        }

        return strtolower($artistName);
    }

    public function getTourDates(Artist $artist)
    {
        $bitUrl = sprintf('/artists/%s/events.json', $artist->getName());
        $tourDates = [];

        $bitResponse = $this->client->get($bitUrl, [
            'http_errors' => false,
            'query' => [
                'api_version' => '2.0',
                'app_id' => $this->appId
            ]
        ]);

        if (Response::HTTP_OK === $bitResponse->getStatusCode()) {
            $tourDates = json_decode((string) $bitResponse->getBody());
        }

        return $tourDates;
    }
}
