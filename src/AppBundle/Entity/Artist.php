<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 06/02/2017
 * Time: 16:11
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArtistRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Artist
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
     * @Assert\Length(min="3", max="100", minMessage="Il va falloir taper au moins {{ limit }} caractères.")
     * 
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThan(value="1970")
     * 
     * @var int
     */
    private $creationYear;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\Length(min=10, max=500)
     *
     * @var string
     */
    private $biography;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Album", mappedBy="artist", fetch="EAGER")
     *
     * @var Album[]
     */
    private $albums;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Genre", inversedBy="artists")
     *
     * @var Genre[]
     */
    private $genres;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="submittedArtists")
     * @var User
     */
    private $createdBy;

    function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Artist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreationYear()
    {
        return $this->creationYear;
    }

    /**
     * @param int $creationYear
     * @return Artist
     */
    public function setCreationYear($creationYear)
    {
        $this->creationYear = $creationYear;

        return $this;
    }

    /**
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param string $biography
     * @return Artist
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * @return ArrayCollection|Album[]
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param Album[] $albums
     * @return Artist
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;

        return $this;
    }

    /**
     * @return ArrayCollection|Genre[]
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @param Genre[] $genres
     * @return Artist
     */
    public function setGenres($genres)
    {
        $this->genres = $genres;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getGenreLabels()
    {
        return $this->getGenres()->map(function(Genre $genre){
            return $genre->getLabel();
        })->toArray();
    }

    /**
     * @return int
     */
    public function getAlbumCount()
    {
        return $this->getAlbums()->count();
    }

    public function addGenre(Genre $genre)
    {
        if (!$this->getGenres()->contains($genre)) {
            $this->getGenres()->add($genre);
        }

    }

    public function removeGenre(Genre $genre)
    {
        if ($this->getGenres()->contains($genre)) {
            $this->getGenres()->removeElement($genre);
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateName()
    {
        //TODO : ALTER ONE OR MORE FIELDS
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return Artist
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
