<?php

namespace App\Tests\Controller;

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
        $this->assertSame(false,$responseData->success);
        $this->assertSame('email can\'t be blank',$responseData->body->message->email);
        $this->assertSame('first name can\'t be blank',$responseData->body->message->firstName);
        $this->assertSame('last name can\'t be blank',$responseData->body->message->lastName);
        $this->assertSame('username can\'t be blank',$responseData->body->message->userName);
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
        $this->assertSame('phone can\'t be blank',$responseData->body->message->phone);
        $this->assertSame('first name can\'t be blank',$responseData->body->message->firstName);
        $this->assertSame('last name can\'t be blank',$responseData->body->message->lastName);
        $this->assertSame('username can\'t be blank',$responseData->body->message->userName);
    }

    public function testUsedEmailRegistratio(): void
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
            $entityManager->persist($user);
            $entityManager->flush();
        }
        $client->jsonRequest('POST', '/api/registration/email', [
            "firstName" => "",
            "lastName" => "",
            "userName" => "",
            "email" => "b.astapau@anderonlab.com",
            "password" => "",
            "confirmPassword" => ""
        ]);
        $response = $client->getResponse();
        $this->assertSame(400,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false,$responseData->success);
        $this->assertSame('This value is already used.',$responseData->body->message->email);
    }

    public function testUsedPhoneRegistratio(): void
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
            $entityManager->persist($user);
            $entityManager->flush();
        }
        $client->jsonRequest('POST', '/api/registration/phone', [
            "firstName" => "",
            "lastName" => "",
            "userName" => "",
            "phone" => "+375291235566",
            "password" => "",
            "confirmPassword" => ""
        ]);
        $response = $client->getResponse();
        $this->assertSame(400,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame(false,$responseData->success);
        $this->assertSame('This value is already used.',$responseData->body->message->phone);
    }

    public function testEmailRegistration(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);
        if($user){
            $entityManager->remove($user);
            $entityManager->flush();
        }
        $client->jsonRequest('POST', '/api/registration/email', [
            "firstName" => "Boris",
            "lastName" => "Astapau",
            "userName" => "b.astapau",
            "email" => "b.astapau@andersenlab.com",
            "password" => "password",
            "confirmPassword" => "password"
        ]);
        $response = $client->getResponse();
        $this->assertSame(201,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
    }

    public function testPhoneRegistration(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)
        ->findOneBy(['phone' => '+375291235566']);
        if($user){
            $entityManager->remove($user);
            $entityManager->flush();
        }
        $client->jsonRequest('POST', '/api/registration/phone', [
            "firstName" => "Boris",
            "lastName" => "Astapau",
            "userName" => "b.astapau",
            "phone" => "+375291235566",
            "password" => "password",
            "confirmPassword" => "password"
        ]);
        $response = $client->getResponse();
        $this->assertSame(201,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
    }
}
