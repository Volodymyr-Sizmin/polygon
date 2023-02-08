<?php

namespace App\Tests\Controller\UtilityPayments;

use App\Entity\Account;
use App\Entity\UtilitiesProvider;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

abstract class AbstractUtilityTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    protected const CURRENCY_GBP = 1;
    protected \Faker\Generator $faker;
    protected $gasUtilityProvider;
    protected $gasUtilityProviderAccount;
    protected KernelBrowser $client;
    protected ?EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->faker = Factory::create();
        $this->entityManager = static::getContainer()->get('doctrine')
            ->getManager();

        $this->gasUtilityProviderAccount = new Account();
        $this->gasUtilityProviderAccount->setCreatedAt(new \DateTimeImmutable());
        $this->gasUtilityProviderAccount->setCurrencyId(self::CURRENCY_GBP);
        $this->gasUtilityProviderAccount->setUserId($this->faker->email());
        $this->gasUtilityProviderAccount->setNumber($this->faker->iban());
        $this->gasUtilityProviderAccount->setCardNumber($this->faker->creditCardNumber());
        $this->entityManager->persist($this->gasUtilityProviderAccount);
        $this->entityManager->flush();

        $this->gasUtilityProvider = new UtilitiesProvider();
        $this->gasUtilityProvider->setAccount($this->gasUtilityProviderAccount->getId());
        $this->gasUtilityProvider->setName($this->faker->company());
        $this->gasUtilityProvider->setUtility('GAS');
        $this->entityManager->persist($this->gasUtilityProvider);
        $this->entityManager->flush();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}