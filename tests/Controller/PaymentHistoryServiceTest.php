<?php

namespace App\Tests\Controller;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaymentHistoryServiceTest extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider userPaymentProvider
     */
    public function testFilterHistoryOfPayments(): void
    {
        $this->client->jsonRequest('GET', '/payments_and_transfers/filter_history');
        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent());
        $this->assertSame([], $responseData);
    }

    public function userPaymentProvider(): array
    {
        $faker = Factory::create();
        return [
            [
                ['amount' => 78, 'status_id' => 3], 201
            ]
        ];
    }
}