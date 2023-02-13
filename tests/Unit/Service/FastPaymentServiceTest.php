<?php

namespace App\Tests\Unit\Service;

use App\DTO\FastPaymentDTO;
use App\Entity\FastPayments;
use App\Repository\FastPaymentsRepository;
use App\Service\FastPaymentService;
use App\Service\TokenService;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FastPaymentServiceTest extends TestCase
{
    private TokenService $tokenService;
    private ManagerRegistry $managerRegistry;

    private FastPaymentService $service;

    protected function setUp(): void
    {
        $this->tokenService = $this->createMock(TokenService::class);
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $client = $this->createMock(HttpClientInterface::class);

        $this->service = new FastPaymentService($client, $this->tokenService, $this->managerRegistry);

        parent::setUp();
    }

    /**
     * Test getFastPayments method
     */
    public function testGetFastPayments(): void
    {
        $token = 'test_token';

        $fastPaymentDTO = $this->createMock(FastPaymentDTO::class);
        $fastPaymentDTO->token = $token;

        $this->tokenService->expects($this->once())
            ->method('getEmailFromToken')
            ->with('test_token')
            ->willReturn('test@gmail.com');

        $fastPaymentRepositoryMock = $this->createMock(FastPaymentsRepository::class);
        $fastPaymentRepositoryMock->expects($this->once())
            ->method('findBy')
            ->with(['user_email' => 'test@gmail.com'])
            ->willReturn([1,2,3]);

        $this->managerRegistry->method('getRepository')
            ->with(FastPayments::class)
            ->willReturn($fastPaymentRepositoryMock);

        $result = $this->service->getFastPayments($fastPaymentDTO);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    /**
     * Test getFastPaymentInfo method
     */
    public function testGetFastPaymentInfo(): void
    {
        $token = 'test_token';

        $fastPaymentDTO = $this->createMock(FastPaymentDTO::class);
        $fastPaymentDTO->templateId = 1;
        $fastPaymentDTO->token = $token;

        $this->tokenService->expects($this->once())
            ->method('getEmailFromToken')
            ->with('test_token')
            ->willReturn('test@gmail.com');

        $fastPayment = $this->createMock(FastPayments::class);
        $fastPayment->expects($this->once())
            ->method('getUserEmail')
            ->willReturn('test@gmail.com');

        $fastPaymentRepositoryMock = $this->createMock(FastPaymentsRepository::class);
        $fastPaymentRepositoryMock->expects($this->once())
            ->method('find')
            ->with($fastPaymentDTO->templateId)
            ->willReturn($fastPayment);

        $this->managerRegistry->method('getRepository')
            ->with(FastPayments::class)
            ->willReturn($fastPaymentRepositoryMock);

        $result = $this->service->getFastPaymentInfo($fastPaymentDTO);

        $this->assertInstanceOf(FastPayments::class, $result);
    }

    public function testGetFastPaymentInfoNoTemplateFound()
    {
        $token = 'test_token';

        $fastPaymentDTO = $this->createMock(FastPaymentDTO::class);
        $fastPaymentDTO->templateId = 1;
        $fastPaymentDTO->token = $token;

        $this->tokenService->expects($this->once())
            ->method('getEmailFromToken')
            ->with('test_token')
            ->willReturn('test@gmail.com');

        $fastPaymentRepositoryMock = $this->createMock(FastPaymentsRepository::class);
        $fastPaymentRepositoryMock->expects($this->once())
            ->method('find')
            ->with($fastPaymentDTO->templateId)
            ->willReturn(null);

        $this->managerRegistry->method('getRepository')
            ->with(FastPayments::class)
            ->willReturn($fastPaymentRepositoryMock);

        $this->expectException('DomainException');
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage("No template found with id $fastPaymentDTO->templateId");

        $this->service->getFastPaymentInfo($fastPaymentDTO);
    }

    /**
     * Test updateFastPayment method
     */
    public function testUpdateFastPayment()
    {
        $token = 'test_token';

        $fastPaymentDTO = $this->createMock(FastPaymentDTO::class);
        $fastPaymentDTO->name = 'test';
        $fastPaymentDTO->templateId = 1;
        $fastPaymentDTO->token = $token;
        $fastPaymentDTO->cardNumber = 1234567890;
        $fastPaymentDTO->paymentReason = 'test';
        $fastPaymentDTO->amount = 100;
        $fastPaymentDTO->accountNumber = 100;
        $fastPaymentDTO->address = 'test';
        $fastPaymentDTO->recepientName = 'test';

        $fastPayment = $this->createMock(FastPayments::class);
        $fastPayment->expects($this->once())->method('getUserEmail')
            ->willReturn('test@gmail.com');

        $this->tokenService->expects($this->once())
            ->method('getEmailFromToken')
            ->with('test_token')
            ->willReturn('test@gmail.com');

        $fastPaymentRepositoryMock = $this->createMock(FastPaymentsRepository::class);
        $fastPaymentRepositoryMock->expects($this->once())
            ->method('find')
            ->with($fastPaymentDTO->templateId)
            ->willReturn($fastPayment);

        $emMock = $this->createMock(EntityManager::class);

        $emMock->expects($this->once())->method('getRepository')
            ->with(FastPayments::class)
            ->willReturn($fastPaymentRepositoryMock);

        $this->managerRegistry->method('getManager')->willReturn($emMock);

        $result = $this->service->updateFastPayment($fastPaymentDTO);

        $this->assertIsArray($result);
        $this->assertEqualsCanonicalizing(
            ['success' => true, 'message' => 'Payment template was successfully updated'],
            $result
        );
    }

    public function testUpdateFastPaymentNoTemplateFound()
    {
        $token = 'test_token';

        $fastPaymentDTO = $this->createMock(FastPaymentDTO::class);
        $fastPaymentDTO->name = 'test';
        $fastPaymentDTO->templateId = 1;
        $fastPaymentDTO->token = $token;
        $fastPaymentDTO->cardNumber = 1234567890;
        $fastPaymentDTO->paymentReason = 'test';
        $fastPaymentDTO->amount = 100;
        $fastPaymentDTO->accountNumber = 100;
        $fastPaymentDTO->address = 'test';
        $fastPaymentDTO->recepientName = 'test';

        $this->tokenService->expects($this->once())
            ->method('getEmailFromToken')
            ->with('test_token')
            ->willReturn('test@gmail.com');

        $fastPaymentRepositoryMock = $this->createMock(FastPaymentsRepository::class);
        $fastPaymentRepositoryMock->expects($this->once())
            ->method('find')
            ->with($fastPaymentDTO->templateId)
            ->willReturn($this->returnValue(false));

        $emMock = $this->createMock(EntityManager::class);

        $emMock->expects($this->once())->method('getRepository')
            ->with(FastPayments::class)
            ->willReturn($fastPaymentRepositoryMock);

        $this->managerRegistry->method('getManager')->willReturn($emMock);

        $this->expectException('DomainException');
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage("No template found with id $fastPaymentDTO->templateId");

        $this->service->updateFastPayment($fastPaymentDTO);
    }

    public function testUpdateFastPaymentEmptyInput()
    {
        $token = 'test_token';

        $fastPaymentDTO = $this->createMock(FastPaymentDTO::class);
        $fastPaymentDTO->templateId = 1;
        $fastPaymentDTO->token = $token;
        $fastPaymentDTO->cardNumber = 1234567890;
        $fastPaymentDTO->paymentReason = 'test';
        $fastPaymentDTO->amount = 100;
        $fastPaymentDTO->accountNumber = 100;
        $fastPaymentDTO->address = 'test';
        $fastPaymentDTO->recepientName = 'test';

        $fastPayment = $this->createMock(FastPayments::class);
        $fastPayment->expects($this->once())->method('getUserEmail')
            ->willReturn('test@gmail.com');

        $this->tokenService->expects($this->once())
            ->method('getEmailFromToken')
            ->with('test_token')
            ->willReturn('test@gmail.com');

        $fastPaymentRepositoryMock = $this->createMock(FastPaymentsRepository::class);
        $fastPaymentRepositoryMock->expects($this->once())
            ->method('find')
            ->with($fastPaymentDTO->templateId)
            ->willReturn($fastPayment);

        $emMock = $this->createMock(EntityManager::class);

        $emMock->expects($this->once())->method('getRepository')
            ->with(FastPayments::class)
            ->willReturn($fastPaymentRepositoryMock);

        $this->managerRegistry->method('getManager')->willReturn($emMock);

        $this->expectException('DomainException');
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage("Empty input");

        $this->service->updateFastPayment($fastPaymentDTO);
    }
}
