<?php

namespace App\Tests;

use App\Factory\UserFactory;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenstruck\Foundry\Test\Factories;

class ProfileTest extends WebTestCase
{
    use Factories;

    private $client;
    private $user;
    private $faker;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->user = UserFactory::createOne()->object();
        $this->faker = Factory::create();
    }

    public function testUploadProfilePhoto(): void
    {
        $this->client->loginUser($this->user);

        $profilePhoto = new UploadedFile($this->faker->image('/tmp', 100, 100), "image_name" . '.png', 'image/png', null, true);

        $this->client->request('POST', '/api/profile/about/photo', [], ['photo' => $profilePhoto]);

        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
        $this->assertTrue($response->success);
        $this->assertSame($response->body->message, 'Profile photo was successfully uploaded.');
    }

    public function testGetProfilePhoto(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('GET', '/api/profile/about/photo');

        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertTrue($response->success);
        $this->assertIsString($response->body->url);
    }

     public function testDeleteProfilePhoto(): void
     {
         $this->client->loginUser($this->user);

         $this->client->request('DELETE', '/api/profile/about/photo');

         $response = json_decode($this->client->getResponse()->getContent());

         $this->assertResponseIsSuccessful();
         $this->assertResponseStatusCodeSame(200);
         $this->assertTrue($response->success);
         $this->assertIsString($response->body->message);
     }
}
