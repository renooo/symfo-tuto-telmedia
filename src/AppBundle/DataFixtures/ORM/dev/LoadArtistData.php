<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 06/02/2017
 * Time: 17:19
 */

namespace AppBundle\DataFixtures\ORM\dev;

use AppBundle\Entity\Artist;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadArtistData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 3;
    }

    public function load(ObjectManager $manager)
    {
        $artists = include __DIR__.'/../data/artists.php';
        $genres = include __DIR__.'/../data/genres.php';
        $users = include __DIR__.'/../data/users.php';

        $faker = \Faker\Factory::create('fr_FR');

        foreach ($artists as $artistData) {
            $artist = new Artist();
            $artist->setName($artistData['name'])
                   ->setCreationYear($artistData['creationYear'])
                   ->setBiography($faker->realText);

            shuffle($genres);
            $bandGenres = array_slice($genres, 0, rand(1, 3));

            foreach ($bandGenres as $bandGenre) {
                $genre = $this->getReference('genre_'.$bandGenre);
                $artist->getGenres()->add($genre);
            }

            $userData = $users[array_rand($users, 1)];
            $user = $this->getReference('user_'.$userData['username']);
            $artist->setCreatedBy($user);
            
            $manager->persist($artist);

            $artistRef = 'artist_'.$artist->getName();
            if (!$this->hasReference($artistRef)) {
                $this->addReference($artistRef, $artist);
            }
        }

        $manager->flush();
    }
}
