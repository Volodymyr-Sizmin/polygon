<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Entity\ResetRequest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResetPasswordTest extends WebTestCase
{

    private function checkEmail($url): void 
    {
        $this->assertEmailCount(1);
        $email = $this->getMailerMessage();
        $this->assertEmailHtmlBodyContains($email, $url, 'email html doesn\'t have a url');
        $this->assertEmailTextBodyContains($email, $url, 'email text doesn\'t have a url');
    }

    public function testEmailRequestCreation(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/reset/email/send', [
            'email'=>'b.astapau@andersenlab.com', 
        ]);
        $this->assertEmailCount(1);
        $response = $client->getResponse();
        $this->assertSame(201,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $url = '/reset/email/'.$responseData->body->url;
        $this->checkEmail($url);
        $client->Request('GET', $url);
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);
        $request = $entityManager->getRepository(ResetRequest::class)->findOneBy(['user' => $user]);
        $this->assertTrue($request->getActivated());
    }

    public function testEmailPasswordReset(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'password@notandersenlab.com']);
        $oldPassword = $user->getPassword();
        $client->jsonRequest('POST', '/api/reset/email/update', [
            'email'=>'password@notandersenlab.com',
            'password'=>'notpassword', 
            'confirmPassword'=>'notpassword' 
        ]);
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'password@notandersenlab.com']);
        $this->assertNotSame($oldPassword, $user->getPassword());
    }
}
