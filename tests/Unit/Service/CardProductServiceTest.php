<?php

namespace App\Tests\Unit\Service;

use App\Entity\Account;
use App\Entity\CardTypes;
use App\Repository\CardTypesRepository;
use App\Service\CardProductService;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class CardProductServiceTest extends TestCase
{
    private CardProductService $cardProductService;
    private TokenService $tokenService;
    private ManagerRegistry $doctrine;

    public function setUp(): void
    {
        $this->tokenService = $this->createStub(TokenService::class);
        $this->tokenService->method('getEmailFromToken')->willReturn('test@gmail.com');
        $this->doctrine = $this->createMock(ManagerRegistry::class);
        $faker = Factory::create();
        $this->service = new CardProductService($this->tokenService, $this->doctrine);
        parent::setUp();
    }

    /**
     * Test getCardProducts method
     */
    public function testGetCardProducts(): void
    {
        $token = 'test_token';
        $this->tokenService->getEmailFromToken($token);
        $cardProductRepositoryMock = $this->createMock(CardTypesRepository::class);
        $cardProductRepositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn([1,2,3]);

        $this->doctrine->method('getRepository')
            ->with(CardTypes::class)
            ->willReturn($cardProductRepositoryMock);

        $result = $this->service->getCardProducts($token);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    /**
     * Test getCardProduct method
     */
    public function testGetCardProduct(): void
    {
        $token = 'test_token';
        $id=1;
        $this->tokenService->getEmailFromToken($token);

        $cardProduct = $this->createMock(CardTypes::class);
//        $cardProduct->expects($this->once())->method('getCurrency')
//            ->willReturn('GBP');

        $cardProductRepositoryMock = $this->createMock(CardTypesRepository::class);
        $cardProductRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($cardProduct);

        $this->doctrine->method('getRepository')
            ->with(CardTypes::class)
            ->willReturn($cardProductRepositoryMock);

        $result = $this->service->getCardProduct($token, $id);

        $this->assertInstanceOf(CardTypes::class, $result);
    }

    /**
     * Test applyCard method
     */
    public function testApplyCard():void
    {
        $token = 'test_token';
        $id=1;
        $body = 'GBP';

        $this->tokenService->getEmailFromToken($token);

        $cardProduct = $this->createMock(CardTypes::class);

        $cardProductRepositoryMock = $this->createMock(CardTypesRepository::class);
        $cardProductRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($cardProduct);

        $this->doctrine->method('getRepository')
            ->with(CardTypes::class)
            ->willReturn($cardProductRepositoryMock);

//        $newAccount = $this->createMock(Account::class);

        $result = $this->service->getCardProduct($token, $id, $body);

        $this->assertIsObject($result);
        $this->assertNotEmpty($result);

    }

}
