<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RegistrationFixtures extends Fixture
{
    const REFERENCE = 'user';
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail($i.'aa@aa.com');
            $user->setToken(mt_rand(1000000, 9999999));
            $user->setPassword('Hello'.$i);
            $manager->persist($user);
        }

        $manager->flush();
        $this->addReference(self::REFERENCE, $user);
    }
}
