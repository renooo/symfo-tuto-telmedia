<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 07/02/2017
 * Time: 09:10
 */

namespace AppBundle\DataFixtures\ORM\prod;

use AppBundle\Entity\Genre;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGenreData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $genres = include __DIR__.'/../data/genres.php';

        foreach ($genres as $genreLabel) {
            $genre = new Genre();
            $genre->setLabel($genreLabel);

            $manager->persist($genre);

            $this->addReference('genre_'.$genreLabel, $genre);
        }

        $manager->flush();
    }
}
