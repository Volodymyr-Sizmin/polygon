<?php

namespace App\Tests\Service;

use App\Entity\Autopayments;
use App\Entity\User;
use App\Service\AutopaymentService;
use App\Service\TokenService;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use PHP_CodeSniffer\Tests\Core\Autoloader\A;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class AutopaymentServiceTest extends WebTestCase
{
    private ?EntityManagerInterface $entityManager;
    private KernelBrowser $client;
    private \Faker\Generator $faker;
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

    public function test_list_of_autopayment(): void
    {
        $testEmail = $this->faker->email();
        $token = "Bearer " . $this->tokenService->createToken(["email" => $testEmail]);

        $this->client->jsonRequest(
            Request::METHOD_GET,
            '/payments_and_transfers/autopayments',
            [],
            [
                'HTTP_Authorization' => $token
            ],
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function test_get_autopayment(): void
    {
        $testEmail = $this->faker->email();
        $token = "Bearer " . $this->tokenService->createToken(["email" => $testEmail]);

        $this->client->jsonRequest(
            Request::METHOD_GET,
            '/payments_and_transfers/autopayment',
            [],
            [
                'HTTP_Authorization' => $token
            ],
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function test_create_autopayment(): void
    {
       // $this->markTestSkipped();

        $testEmail = $this->faker->email();
        $token = "Bearer " . $this
                ->tokenService
                ->createToken([
                    "email" => $testEmail
                   ]);


        $this->client->jsonRequest(
            Request::METHOD_POST,
            '/payments_and_transfers/autopayment',
            [
                "name_of_payment" => "qwerty",
                "payment_category" => "water",
                "customer_number" => "12345678",
                "amount" => "20",
                "card" => "4990588351056682",
                "payments_period" => "once a month",
                "auto_charge_off" => "0"
            ],
            [
                'HTTP_Authorization' => $token
            ],
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function test_pause_autopayment(): void
    {
        $this->markTestSkipped();
    }



    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
