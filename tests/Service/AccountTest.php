<?php

namespace App\Tests\Service;

use App\Entity\Account;
use App\Service\AccountsService;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AccountTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager;
    public function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testAccountCreation(): void
    {
        $kernel = self::bootKernel();
        $accountService = static::getContainer()->get(AccountsService::class);
        $faker = Factory::create();
        $testEmail = $faker->email();
        $number = $accountService->createAccountByEmail($testEmail);
        $this->assertNotNull($number);

        $newAccount = $this->entityManager->getRepository(Account::class)
            ->findOneBy(['user_id' => $testEmail]);
        $this->assertSame($testEmail, $newAccount->getUserId());
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
