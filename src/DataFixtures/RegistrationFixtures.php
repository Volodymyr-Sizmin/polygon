<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegistrationFixtures extends Fixture
{
    public const REFERENCE = 'user';

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; ++$i) {
            $user = new User();
            $user->setEmail('alex'.$i.'@aa.com');
            $user->setToken(mt_rand(1000000, 9999999));
            $user->setPassword('Hello Alex'.$i);
            $manager->persist($user);
        }

        $manager->flush();
        $this->addReference(self::REFERENCE, $user);
    }
}
