<?php

namespace App\Tests\Controller;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServiceTest extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testGetServices(): void
    {
        $this->client->jsonRequest('GET', '/payments_and_transfers/services');
        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent());
        $this->assertSame([], $responseData);
    }
}
