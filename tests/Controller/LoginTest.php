<?php

namespace App\Tests\Feature\Controller;

use App\Entity\User;
use App\Entity\ApiToken;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testEmailLogin(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/login/email', [
            "email"=>"b.astapau@andersenlab.com", 
            "password"=>"password"
        ]);
        $response = $client->getResponse();
        $this->assertSame(200,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $this->assertMatchesRegularExpression('/(\S){60}/',$responseData->body->token);
    }

    public function testPhoneLogin(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/login/phone', [
            "phone"=>"+375291235566", 
            "password"=>"password"
        ]);
        $response = $client->getResponse();
        $this->assertSame(200,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $this->assertMatchesRegularExpression('/(\S){60}/',$responseData->body->token);
    }

    public function testAccess(): void
    {
        $client = static::createClient();
        $client->jsonRequest('GET', '/api/account');
        $response = $client->getResponse();
        $this->assertSame(401,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false, $responseData->success);
        $this->assertSame('No API token provided',$responseData->body->message);
    }
}
