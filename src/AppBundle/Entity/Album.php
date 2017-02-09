<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 06/02/2017
 * Time: 16:12
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Album
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $releaseDate;

    /**
     * @var Track[]
     */
    private $tracks;

    /**
     * @ORM\Column(type="time", nullable=true)
     *
     * @var \DateTime
     */
    private $totalDuration;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Artist", inversedBy="albums")
     * 
     * @var Artist
     */
    private $artist;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Album
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTime $releaseDate
     * @return Album
     */
    public function setReleaseDate(\DateTime $releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return Track[]
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * @param Track[] $tracks
     * @return Album
     */
    public function setTracks($tracks)
    {
        $this->tracks = $tracks;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTotalDuration()
    {
        return $this->totalDuration;
    }

    /**
     * @param \DateTime $totalDuration
     * @return Album
     */
    public function setTotalDuration($totalDuration)
    {
        $this->totalDuration = $totalDuration;

        return $this;
    }

    /**
     * @return Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param Artist $artist
     * @return Album
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;

        return $this;
    }
}
