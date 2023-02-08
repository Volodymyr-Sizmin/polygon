<?php

namespace App\Tests\Controller\UtilityPayments\UtilityPayments;

use App\Entity\Account;
use App\Service\CardGatewayAdapter\GoGatewayAdapter;
use App\Service\MoneyTransferService;
use App\Service\TokenService;
use App\Tests\Controller\UtilityPayments\AbstractUtilityTest;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class UtilityPaymentsControllerTest extends AbstractUtilityTest
{
    private $tokenService;
    private Account $payerAccount;
    public function setUp(): void
    {
        parent::setUp();
        $this->tokenService = static::getContainer()->get(TokenService::class);
        $this->payerAccount = new Account();
        $this->payerAccount->setCreatedAt(new \DateTimeImmutable());
        $this->payerAccount->setCurrencyId(self::CURRENCY_GBP);
        $this->payerAccount->setUserId($this->faker->email());
        $this->payerAccount->setNumber($this->faker->iban());
        $this->payerAccount->setCardNumber($this->faker->creditCardNumber());
        $this->entityManager->persist($this->payerAccount);
        $this->entityManager->flush();
    }

    public function testPayByCard(): void
    {
        $moneyTransferServiceMock = $this->createMock(MoneyTransferService::class);
        $moneyTransferServiceMock->expects($this->once())
            ->method('transferBetweenAccounts')
            ->with($this->payerAccount, $this->gasUtilityProviderAccount);
        $this->client->getContainer()->set(MoneyTransferService::class, $moneyTransferServiceMock);
        $token = "Bearer " . $this->tokenService->createToken(["email" => $this->payerAccount->getId()]);
        $requestBody = [
            "payerAccountNumber" => $this->payerAccount->getNumber(),
            "payerCardNumber" => $this->payerAccount->getCardNumber(),
            "utilityProviderId" => $this->gasUtilityProvider->getId(),
            "currency" => "GBP",
            "paymentAmount" => $this->faker->randomFloat(2),
            "subject" => "Test Payment",
        ];
        $response = $this->client->jsonRequest(
            Request::METHOD_POST,
            '/utilities/pay',
            $requestBody,
            [
                'HTTP_Authorization' => $token,
            ],
        );
        $this->assertResponseIsSuccessful();

        //dd($response->getStatusCode());




    }
}
