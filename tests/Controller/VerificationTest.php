<?php

namespace App\Tests;

use App\Entity\VerificationRequest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VerificationTest extends WebTestCase
{

    private function checkEmail($url): void 
    {
        $this->assertEmailCount(1);
        $email = $this->getMailerMessage();
        $this->assertEmailHtmlBodyContains($email, $url, 'email html doesn\'t have a url');
        $this->assertEmailTextBodyContains($email, $url, 'email text doesn\'t have a url');
    }

    public function testVerificationRequest(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/verify/email/send', [
            "email"=>"verification@notandersenlab.com", 
        ]);
        $response = $client->getResponse();
        $this->assertSame(201, $response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $url = '/verify/email/'.$responseData->body->url;
        $this->checkEmail($url);
        $client->Request('GET', $url);
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $request = $entityManager->getRepository(VerificationRequest::class)->findOneBy(['email' => 'verification@notandersenlab.com']);
        $this->assertTrue($request->getVerified());
    }
}
