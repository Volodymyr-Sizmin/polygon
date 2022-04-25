<?php

namespace App\Tests\Feature\Entity;

use App\Entity\User;
use App\Entity\ApiToken;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApiTokenTest extends KernelTestCase
{
    private $entityManager;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testApiTokenCreation(): void
    {
        $user = new User();
        $token = new ApiToken($user);
        $this->assertSame($user, $token->getUser());
        $this->assertMatchesRegularExpression('/(\S){60}/', $token->getToken());
        $this->assertTrue($token->getExpiresAt() > new \DateTime(), 'expires too early');
        $this->assertTrue($token->getExpiresAt() < new \DateTime('+1 hour'), 'expires too late');
        $token->setRemember(true);
        $token->renewExpiresAt();
    }

    public function testApiTokenTimeout(): void
    {
        $user = new User();
        $token = new ApiToken($user);
        $token->setExpiresAt(new \DateTime('-2 hour'));
        $this->assertTrue($token->checkExpired());
        $token->renewExpiresAt();
        $this->assertFalse($token->checkExpired());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
