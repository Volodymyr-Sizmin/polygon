<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Currency;
use App\Entity\UtilitiesProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UtilityProvidersFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    public function load(ObjectManager $manager): void
    {
        foreach (range(1, 6) as $accountIterator) {
            $account = new Account();
            $account->setUserId('qatest6@gmail.com');
            $account->setNumber($this->faker->lexify('????????'));
            $account->setCardNumber($this->faker->creditCardNumber());
            $account->setCurrencyId(1);
            $account->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($account);
            $manager->flush();

            $provider = new UtilitiesProvider();
            $provider->setUtility('gas');
            $provider->setAccount($account->getId());
            $provider->setName($this->faker->lexify('?????'));
            $manager->persist($provider);
            $manager->flush();

            $currency = new Currency();
            $currency->setName('GBP');
            $currency->setFullName('British pound sterling');
            $manager->persist($currency);
            $manager->flush();
        }
    }
}
