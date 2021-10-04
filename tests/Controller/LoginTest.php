<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Entity\ApiToken;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testEmailLogin(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);
        if(!$user){
            $user = new User();
            $user->setFirstName('Boris');
            $user->setLastName('Astapau');
            $user->setUserName('b.astapau');
            $user->setEmail('b.astapau@andersenlab.com');
            $user->setPassword('$2y$13$2Fh6tHiRuo6stBS.pC0zlu8RqK8tLQ3rM3jHZz5uZZKohcifpstjS');
        }
        $user->setVerified(true);
        $entityManager->persist($user);
        $entityManager->flush();
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
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['phone' => '+375291235566']);
        if(!$user){
            $user = new User();
            $user->setFirstName('Boris');
            $user->setLastName('Astapau');
            $user->setUserName('b.astapau');
            $user->setPhone('+375291235566');
            $user->setPassword('$2y$13$2Fh6tHiRuo6stBS.pC0zlu8RqK8tLQ3rM3jHZz5uZZKohcifpstjS');
        }
        $user->setVerified(true);
        $entityManager->persist($user);
        $entityManager->flush();
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
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class);
        $client->jsonRequest('GET', '/api/account');
        $response = $client->getResponse();
        $this->assertSame(401,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false, $responseData->success);
        $this->assertSame('No API token provided',$responseData->body->message);
    }
}
