<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\City;
use App\Entity\Country;

class CityFixtures extends Fixture implements DependentFixtureInterface
{
    private function loadGomel(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Gomel');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Belarus']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadMinsk(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Minsk');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Belarus']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadPolotsk(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Polotsk');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Belarus']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadVitebsk(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Vitebsk');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Belarus']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadKrakow(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Krakow');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Poland']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadKazan(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Kazan');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Russia']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadRemoteRF(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Remote RF');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Russia']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadRostov(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Rostov');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Russia']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadSaintPetersburg(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Saint-Petersburg');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Russia']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadCherkasy(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Cherkasy');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Ukraine']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadChernihiv(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Chernihiv');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Ukraine']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadDnipro(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Dnipro');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Ukraine']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadKharkiv(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Kharkiv');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Ukraine']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadKyiv(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Kyiv');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Ukraine']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    private function loadOdessa(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Odessa');
        $country = $manager->getRepository(Country::class)->findOneBy(['name' => 'Ukraine']);
        $city->setCountry($country);
        $manager->persist($city);

        $manager->flush();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadGomel($manager);
        $this->loadMinsk($manager);
        $this->loadPolotsk($manager);
        $this->loadVitebsk($manager);
        $this->loadKrakow($manager);
        $this->loadKazan($manager);
        $this->loadRemoteRF($manager);
        $this->loadRostov($manager);
        $this->loadSaintPetersburg($manager);
        $this->loadCherkasy($manager);
        $this->loadChernihiv($manager);
        $this->loadDnipro($manager);
        $this->loadKharkiv($manager);
        $this->loadKyiv($manager);
        $this->loadOdessa($manager);
    }

    public function getDependencies()
    {
        return [
            CountryFixtures::class,
        ];
    }
}
