<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VerificationTest extends WebTestCase
{
    public function testVerificationRequest(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'b.astapau@anderonlab.com']);
        if(!$user){
            $user = new User();
            $user->setFirstName('Boris');
            $user->setLastName('Astapau');
            $user->setUserName('b.astapau');
            $user->setEmail('b.astapau@anderonlab.com');
            $user->setPassword('$2y$13$2Fh6tHiRuo6stBS.pC0zlu8RqK8tLQ3rM3jHZz5uZZKohcifpstjS');
        }
        $user->setVerified(false);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->assertFalse($user->getVerified(),'1');
        $client->jsonRequest('POST', '/api/verify/email/send', [
            "email"=>"b.astapau@anderonlab.com", 
        ]);
        $response = $client->getResponse();
        $this->assertSame(201,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $url = '/verify/email/'.$responseData->body->url;
        $client->Request('GET', $url);
        $response = $client->getResponse();
        $this->assertSame(200,$response->getStatusCode());
        $user = $entityManager->getRepository(User::class)
        ->findOneBy(['email' => 'b.astapau@anderonlab.com']);
        $this->assertTrue($user->getVerified(),'2');
    }
}
