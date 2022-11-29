<?php

namespace App\Tests\Controller;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterTest extends WebTestCase
{
    protected KernelBrowser $client;


    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider userDataProvider
     */
    public function testEmailRegistration($email, int $expectedCode): void
    {
        $headers = ['content-Type' => 'application/json', 'accept' => 'application/json'];
        $this->client->jsonRequest('POST', 'registration_service/sendemail', $email, $headers);
        $response = $this->client->getResponse();
        $this->assertSame($expectedCode, $response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(true, $responseData->success);
    }

    /**
     * @dataProvider userDataProvider
     */
    public function testEmptyEmailRegistration(): void
    {
        $headers = ['content-Type' => 'application/json', 'accept' => 'application/json'];
        $this->client->jsonRequest('POST', 'registration_service/sendemail', [], $headers);
        $response = $this->client->getResponse();
        $this->assertSame(404, $response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false, $responseData->success);
    }

    /**
     * @dataProvider codeDataProvider
     */
    public function testNoMatchCode($code): void
    {
        $headers = ['content-Type' => 'application/json', 'accept' => 'application/json'];
        $this->client->jsonRequest('POST', '/registration_service/code', $code, $headers);
        $response = $this->client->getResponse();
        $this->assertSame(400, $response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false, $responseData->success);
    }

    public function userDataProvider(): array
    {
        $faker = Factory::create();
        return [
            [
                ['email' => $faker->email], 201
            ]
        ];
    }

    public function codeDataProvider(): array
    {
        $faker = Factory::create();
        return [
            [
                ['code' => $faker->randomDigit(6)]
            ]
        ];
    }
}