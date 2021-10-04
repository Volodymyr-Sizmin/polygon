<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\VerificationRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VerificationRequestTest extends KernelTestCase
{
    private $entityManager;
    public function setUp() : void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testVerificationRequestCreation(): void
    {
        $user = new User();
        $request = new VerificationRequest($user);
        $this->assertSame($user,$request->getUser());
        $this->assertNotEmpty($request->getUrl());
    }

    public function testVerificationRequesTimeout(): void
    {
        $user = new User();
        $request = new VerificationRequest($user);
        $this->assertFalse($request->checkExpired());
        $request->setExpiresAt(new \DateTime('-2 hour'));
        $this->assertTrue($request->checkExpired());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
