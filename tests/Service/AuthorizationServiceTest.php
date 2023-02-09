<?php

namespace App\Tests\Service;

use App\Service\AuthorizationService;
use App\Service\TokenService;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthorizationServiceTest extends KernelTestCase
{
    private string $randomToken;
    private Generator $faker;
    private TokenService $tokenServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->tokenServiceMock = $this->createMock(TokenService::class);
        $this->randomToken = $this->faker->creditCardNumber();
    }

    public function testSuccessfulAuthorization(): void
    {
        $testEmail = $this->faker->email();
        $mockResponseData = (object) [
            'data' => (object) [
                'email' => $testEmail,
            ],
        ];
        $this->tokenServiceMock->expects($this->any())
            ->method('decodeToken')
            ->with($this->equalTo(substr($this->randomToken, 7)))
            ->willReturn($mockResponseData);
        $authService = new AuthorizationService($this->tokenServiceMock);

        $resultEmail = $authService->getEmailFromHeaderToken($this->randomToken);

        $this->assertSame($testEmail, $resultEmail);
    }

    public function testBadToken(): void
    {
        $this->tokenServiceMock->expects($this->any())
            ->method('decodeToken')
            ->with($this->equalTo(substr($this->randomToken, 7)))
            ->willReturn(null);
        $authService = new AuthorizationService($this->tokenServiceMock);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('No email provided');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);
        $resultEmail = $authService->getEmailFromHeaderToken($this->randomToken);
    }

    public function testEmptyToken(): void
    {
        $this->tokenServiceMock->expects($this->any())
            ->method('decodeToken')
            ->with($this->equalTo(substr($this->randomToken, 7)))
            ->willReturn($this->randomToken);
        $authService = new AuthorizationService($this->tokenServiceMock);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Not authenticated');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);

        $authService->getEmailFromHeaderToken('');
    }
}
