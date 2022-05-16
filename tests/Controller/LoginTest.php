<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('1aa@aa.com');

        $client->loginUser($testUser);

        $client->request('POST', '/api/auth/login');
        $this->assertResponseIsSuccessful();
    }
}
