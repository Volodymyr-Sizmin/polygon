<?php

namespace App\Tests\Controller;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainPageControllerTest extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testGetFastPayments(): void
    {
        $this->client->jsonRequest('GET', '/payments_and_transfers/fast_payments');
        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent());
        $this->assertSame([], $responseData);
    }

    public function testGetAutoPayments(): void
    {
        $this->client->jsonRequest('GET', '/payments_and_transfers/auto_payments');
        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent());
        $this->assertSame([], $responseData);
    }

    public function testGetPaymentTypes(): void
    {
        $this->client->jsonRequest('GET', '/payments_and_transfers/payment_types');
        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent());
        $this->assertSame([], $responseData);
    }
}
