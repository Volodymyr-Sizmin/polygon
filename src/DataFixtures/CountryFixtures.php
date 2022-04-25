<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Country;

class CountryFixtures extends Fixture
{
    private function loadBelarus(ObjectManager $manager): void
    {
        $country = new Country();
        $country->setName('Belarus');
        $manager->persist($country);
        $manager->flush();
    }

    private function loadPoland(ObjectManager $manager): void
    {
        $country = new Country();
        $country->setName('Poland');
        $manager->persist($country);
        $manager->flush();
    }

    private function loadRussia(ObjectManager $manager): void
    {
        $country = new Country();
        $country->setName('Russia');
        $manager->persist($country);
        $manager->flush();
    }

    private function loadUkraine(ObjectManager $manager): void
    {
        $country = new Country();
        $country->setName('Ukraine');
        $manager->persist($country);
        $manager->flush();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadBelarus($manager);
        $this->loadPoland($manager);
        $this->loadRussia($manager);
        $this->loadUkraine($manager);
    }
}
