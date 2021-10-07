<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VerificationTest extends WebTestCase
{
    public function testVerificationRequest(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/verify/email/send', [
            "email"=>"verification@notandersenlab.com", 
        ]);
        $response = $client->getResponse();
        $this->assertSame(201,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $url = '/verify/email/'.$responseData->body->url;
        $client->Request('GET', $url);
        $response = $client->getResponse();
        $this->assertSame(200,$response->getStatusCode());
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'verification@notandersenlab.com']);
        $this->assertTrue($user->getVerified());
    }
}
