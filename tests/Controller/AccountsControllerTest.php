<?php

namespace App\Tests\Controller;

use App\Entity\Account;
use App\Service\TokenService;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class AccountsControllerTest extends WebTestCase
{
    private ?EntityManagerInterface $entityManager;
    private KernelBrowser $client;
    private $faker;
    private TokenService $tokenService;
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $kernel = self::bootKernel();

        $container = static::getContainer();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->tokenService = $container->get(TokenService::class);
        $this->faker = Factory::create();
    }
    public function testAccountCreation(): void
    {
        $testEmail = $this->faker->email();
        // TODO: refactor this after my merge
        $token = "Bearer " . $this->tokenService->createToken(["email" => $testEmail]);

        $this->client->jsonRequest(
            Request::METHOD_POST,
            '/accounts/create',
            [],
            [
                'HTTP_Authorization' => $token
            ],
        );
        $accountNumber = json_decode($this->client->getResponse()->getContent());
        /** @var Account $newAccount */
        $newAccount = $this->entityManager->getRepository(Account::class)
            ->findOneBy(['number' => $accountNumber]);



        $this->assertResponseIsSuccessful();
        $this->assertNotNull($newAccount);
        $this->assertSame($newAccount->getNumber(), $accountNumber);
        $this->assertSame($newAccount->getUserId(), $testEmail);
    }


    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
