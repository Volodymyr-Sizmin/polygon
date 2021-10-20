<?php

namespace App\Tests\Feature\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationTest extends WebTestCase
{
    public function testEmptyEmailRegistratio(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/registration/email', [
            "firstName" => "",
            "lastName" => "",
            "userName" => "",
            "email" => "",
            "password" => "",
            "confirmPassword" => ""
        ]);
        $response = $client->getResponse();
        $this->assertSame(400,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false, $responseData->success);
        $this->assertSame('Invalid e-mail Address', $responseData->body->message->email);
        $this->assertSame('Must be 2 characters or more', $responseData->body->message->firstName);
        $this->assertSame('Must be 2 characters or more', $responseData->body->message->lastName);
        $this->assertSame('Must be 2 characters or more', $responseData->body->message->userName);
    }

    public function testEmptyPhoneRegistratio(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/registration/phone', [
            "firstName" => "",
            "lastName" => "",
            "userName" => "",
            "phone" => "",
            "password" => "",
            "confirmPassword" => ""
        ]);
        $response = $client->getResponse();
        $this->assertSame(400,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false,$responseData->success);
        $this->assertSame('Must be 7 characters or more', $responseData->body->message->phone);
        $this->assertSame('Must be 2 characters or more', $responseData->body->message->firstName);
        $this->assertSame('Must be 2 characters or more', $responseData->body->message->lastName);
        $this->assertSame('Must be 2 characters or more', $responseData->body->message->userName);
    }

    public function testUsedEmailRegistratio(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/registration/email', [
            "firstName" => "",
            "lastName" => "",
            "userName" => "",
            "email" => "b.astapau@andersenlab.com",
            "password" => "",
            "confirmPassword" => ""
        ]);
        $response = $client->getResponse();
        $this->assertSame(400, $response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false, $responseData->success);
        $this->assertSame('This value is already used.', $responseData->body->message->email);
    }

    public function testUsedPhoneRegistratio(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/registration/phone', [
            "firstName" => "",
            "lastName" => "",
            "userName" => "",
            "phone" => "+375291235566",
            "password" => "",
            "confirmPassword" => ""
        ]);
        $response = $client->getResponse();
        $this->assertSame(400, $response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false, $responseData->success);
        $this->assertSame('This value is already used.', $responseData->body->message->phone);
    }

    public function testEmailRegistration(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/registration/email', [
            "firstName" => "Boris1",
            "lastName" => "Astapau1",
            "userName" => "b.astapau1",
            "email" => "b.astapau@andersenlab1.com",
            "password" => "password",
            "confirmPassword" => "password"
        ]);
        $response = $client->getResponse();
        $this->assertSame(201,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab1.com']);
        $this->assertNotNull($user);
    }

    public function testPhoneRegistration(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/registration/phone', [
            "firstName" => "Boris2",
            "lastName" => "Astapau2",
            "userName" => "b.astapau2",
            "phone" => "+375291235562",
            "password" => "password",
            "confirmPassword" => "password"
        ]);
        $response = $client->getResponse();
        $this->assertSame(201, $response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['phone' => '+375291235562']);
        $this->assertNotNull($user);
    }
}
