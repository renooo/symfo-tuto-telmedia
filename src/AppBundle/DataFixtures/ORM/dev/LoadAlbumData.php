<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 07/02/2017
 * Time: 09:20
 */

namespace AppBundle\DataFixtures\ORM\dev;

use AppBundle\Entity\Album;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAlbumData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 4;
    }

    public function load(ObjectManager $manager)
    {
        $albums = include __DIR__.'/../data/albums.php';

        foreach ($albums as $albumData) {
            $album = new Album();
            $album->setTitle($albumData['title'])
                  ->setReleaseDate(new \DateTime($albumData['releaseDate']));

            $artistRef = 'artist_'.$albumData['artist'];

            if (!$this->hasReference($artistRef)) {
                continue;
            }

            $artist = $this->getReference($artistRef);
            $album->setArtist($artist);

            $manager->persist($album);
        }

        $manager->flush();
    }
}
