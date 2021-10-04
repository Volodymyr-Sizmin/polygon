<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Entity\ResetRequest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResetPasswordTest extends WebTestCase
{
    public function testEmailRequestCreation(): void
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
        $client->jsonRequest('POST', '/api/reset/email/send', [
            "email"=>"b.astapau@andersenlab.com", 
        ]);
        $response = $client->getResponse();
        $this->assertSame(201,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $url = '/reset/email/'.$responseData->body->url;
        $client->Request('GET', $url);
        $response = $client->getResponse();
        $this->assertSame(200,$response->getStatusCode());
        $request = $entityManager->getRepository(ResetRequest::class)
        ->findOneBy(['user' => $user]);
        $this->assertTrue($request->getActivated());
    }

    public function testEmailPasswordReset(): void
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
        }
        $user->setPassword('$2y$13$2Fh6tHiRuo6stBS.pC0zlu8RqK8tLQ3rM3jHZz5uZZKohcifpstjS');
        $user->setVerified(true);
        $request = $entityManager->getRepository(ResetRequest::class)->findOneBy(['user' => $user]);
        if(!$request){
            $request = new ResetRequest($user);
        }
        $request->setActivated(true);
        $entityManager->persist($request);
        $entityManager->persist($user);
        $entityManager->flush();
        $client->jsonRequest('POST', '/api/reset/email/update', [
            "email"=>"b.astapau@andersenlab.com",
            "password"=>"notpassword", 
            "confirmPassword"=>"notpassword" 
        ]);
        $response = $client->getResponse();
        $this->assertSame(200,$response->getStatusCode());
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);
        $this->assertNotSame('$2y$13$2Fh6tHiRuo6stBS.pC0zlu8RqK8tLQ3rM3jHZz5uZZKohcifpstjS', $user->getPassword());
        $entityManager->remove($user);
        $entityManager->flush();
    }
}
