<?php

namespace App\Tests\Service;

use App\Service\TokenService;
use App\Service\UserService;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class UserServiceTest extends KernelTestCase
{
    private $tokenService;
    private $faker;
    private $httpClientMock;
    private $responseMock;

    public function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        $this->tokenService = static::getContainer()->get(TokenService::class);
        $this->faker = Factory::create();
        $this->httpClientMock = $this->createMock(HttpClientInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
        $this->httpClientMock
            ->method('request')
            ->willReturn($this->responseMock);
        static::getContainer()->set(HttpClientInterface::class, $this->httpClientMock);
    }

    public function testAnswerValid(): void
    {
        $validAnswer = $this->faker->lexify('?????????');
        $token = $this->tokenService->createGoToken(['email' => $this->faker->email()]);
        $this->responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode(['answer' => $validAnswer]));
        $userService = new UserService($this->httpClientMock, $this->tokenService);
        $userService->assertSecretAnswerValid($validAnswer, $token);

        $this->assertTrue(true);
    }

    public function testAnswerInvalid(): void
    {
        $validAnswer = $this->faker->lexify('?????????');
        $notValidAnswer = $this->faker->lexify('???');
        $token = $this->tokenService->createGoToken(['email' => $this->faker->email()]);
        $this->responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode(['answer' => $notValidAnswer]));
        $userService = new UserService($this->httpClientMock, $this->tokenService);
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Wrong Secret question answer');
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $userService->assertSecretAnswerValid($validAnswer, $token);
    }
}
