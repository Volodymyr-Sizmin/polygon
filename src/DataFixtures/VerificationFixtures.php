<?php

namespace App\DataFixtures;

use App\Entity\VerificationRequest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VerificationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $email = 'b.astapau@andersenlab1.com';
        $request = new VerificationRequest($email);
        $request->setVerified(true);
        $manager->persist($request);
        $manager->flush();
    }
}
