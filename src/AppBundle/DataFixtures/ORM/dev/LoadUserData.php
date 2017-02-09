<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 08/02/2017
 * Time: 16:38
 */

namespace AppBundle\DataFixtures\ORM\dev;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        $users = include __DIR__.'/../data/users.php';

        foreach ($users as $userData) {
            $user = new User();
            $user->setUsername($userData['username'])
                 ->setEmail($userData['email'])
                 ->setPlainPassword($userData['password'])
                 ->setEnabled(true);

            $manager->persist($user);

            $this->setReference('user_'.$userData['username'], $user);
        }

        $manager->flush();
    }
}
