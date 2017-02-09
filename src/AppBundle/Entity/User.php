<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 08/02/2017
 * Time: 15:48
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Artist", mappedBy="createdBy")
     *
     * @var Artist[]
     */
    protected $submittedArtists;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection|Artist[]
     */
    public function getSubmittedArtists()
    {
        return $this->submittedArtists;
    }

    /**
     * @param Artist[] $submittedArtists
     * @return User
     */
    public function setSubmittedArtists($submittedArtists)
    {
        $this->submittedArtists = $submittedArtists;

        return $this;
    }
}
