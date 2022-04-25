<?php

namespace App\Tests;

use App\Entity\VerificationRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VerificationRequestTest extends KernelTestCase
{
    private $entityManager;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testVerificationRequestCreation(): void
    {
        $email = 'p.test@andersenlab.com';
        $request = new VerificationRequest($email);
        $this->assertSame($email, $request->getEmail());
        $this->assertNotEmpty($request->getUrl());
    }

    public function testVerificationRequesTimeout(): void
    {
        $email = 'p.test@andersenlab.com';
        $request = new VerificationRequest($email);
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
