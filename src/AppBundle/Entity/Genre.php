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
class Genre
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
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $label;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Artist", mappedBy="genres")
     *
     * @var Artist[]
     */
    private $artists;

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
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Genre
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Artist[]
     */
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * @param Artist[] $artists
     * @return Genre
     */
    public function setArtists($artists)
    {
        $this->artists = $artists;

        return $this;
    }
}