<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 08/02/2017
 * Time: 12:05
 */

namespace AppBundle\Event;

use AppBundle\Entity\Artist;
use Symfony\Component\EventDispatcher\Event;

class ArtistEvent extends Event
{
    /**
     * @var Artist
     */
    protected $artist;

    function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }
}
