<?php

namespace App\Tests\Controller;

use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CardsControllerTest extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $container = static::getContainer();
        $this->tokenService = $container->get(TokenService::class);
    }

    public function testPaymentByRequisites()
    {
        $testEmail = "qatest@gmail.com";
        $token = 'Bearer ' . $this->tokenService->createToken(["email" => $testEmail]);
        $method = 'POST';
        $uri = '/qatest@gmail.com/cards';
        $headers = [
            'HTTP_Authorization' => $token
        ];

        $this->client->jsonRequest($method, $uri,[], $headers);

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
    /* public function testPaymentByRequisitesFail()
     {
         $testEmail = "qatest@gmail.com";
         $token = 'Bearer ' . $this->tokenService->createToken(["email" => $testEmail]);
         $method = 'POST';
         $uri = '/service/payments/qatest@gmail.com/byrequisites';
         $headers = [
             'HTTP_Authorization' => $token
         ];
         $body = [
             "cardNumber" => "1111-1111-0000",
             "amount" => 100,
             "account_debit" => "11111111111111111111",
             "address" => "any address",
             "firstName" => "Joe",
             "secondName" => "Stive",
             "description" => "Some Description"
         ];
         $this->client->jsonRequest($method, $uri, $body, $headers);

         $this->assertSame(404, $this->client->getResponse()->getStatusCode());
     }*/
}
