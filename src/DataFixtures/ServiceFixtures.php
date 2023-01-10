<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public const REFERENCE = 'services';

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; ++$i) {
            $service = new Service();
            $service->setName('Service N'.$i);
            $service->setServiceId('Service_n_'.$i);
            $service->setDescription('Description_#'.$i);
            $service->setPicture('Picture_#'.$i);
            $manager->persist($service);
        }

        $manager->flush();
        $this->addReference(self::REFERENCE, $service);
    }
}
