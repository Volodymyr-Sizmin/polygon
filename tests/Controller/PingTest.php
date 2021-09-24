<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PingTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/ping');
        $response = $client->getResponse();
        $this->assertSame(200,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, 'pong');
    }
}
