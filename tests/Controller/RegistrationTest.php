<?php

namespace App\Tests\Controller;

use App\Entity\BankUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\Client;
use GuzzleHttp;
use Symfony\Component\HttpFoundation\Request;

class RegistrationTest extends WebTestCase
{
    public function testEmptyPhoneRegistration(): void
    {
        $client = static::createClient();
        $data = [
            "phone" => "",
            "password" => "",
        ];
        $client->jsonRequest('POST', 'api/auth/register', $data);
        $response = $client->getResponse();
        $this->assertSame(400,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false, $responseData->success);
        //$this->assertSame('Must be 10 characters or more', $responseData->body->message->phone);
    }

    public function testUsedPhoneRegistration(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', 'api/auth/register', [
            "phone" => "+375 29 61778847601",
            "password" => "",
        ]);
        $response = $client->getResponse();
        $this->assertSame(400, $response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false, $responseData->success);
        //$this->assertSame('This value is already used.', $responseData->body->message->phone);
    }

    public function testPhoneRegistration(): void
    {
        $client = new Client();
        $this->client = static::createClient();
        $data = [
            'content' => [
                "phone" => "+375 29 61778847606",

                "password" => "123456789",
            ]

        ];

        $response = $client->post('api/auth/register', [
            GuzzleHttp\RequestOptions::JSON => [
                'title' => 'phone', 'body' => '+375 29 61778847606',
                'title1' => 'password', 'body1' => '123456789'
            ]
        ]);

        dd($response);
        /*$this->client->request(
            'POST',
            '/api/auth/register',

            array(),
            array('content' => [
                "phone" => "+375 29 61778847606",

                "password" => "123456789"]),
            array('CONTENT_TYPE' => 'application/json'),
        '[{"phone":"+375 29 61778847606"","password":"123456789"},{"title":"title2","body":"body2"}]'
        );*/
        //$client->jsonRequest('POST', 'api/auth/register', $data);

        $response = $client->getResponse();

        $this->assertJsonResponse($this->client->getResponse(), 201, false);

        /*$this->assertSame(201, $response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(BankUser::class)->findOneBy(['phone' => '+375 29 61778847606']);
        $this->assertNotNull($user);*/
    }

    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }
}
