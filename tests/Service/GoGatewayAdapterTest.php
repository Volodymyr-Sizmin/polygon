<?php

namespace App\Tests\Service;

use App\Service\CardGatewayAdapter\GoGatewayAdapter;
use App\Service\TokenService;
use Faker\Factory;
use Faker\Generator;
use SebastianBergmann\Type\GenericObjectType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GoGatewayAdapterTest extends KernelTestCase
{
    private TokenService $tokenServiceMock;
    private HttpClientInterface $httpClientMock;
    private ResponseInterface $responseMock;
    private Generator $faker;
    private string $randomToken;
    private string $randomEmail;
    private string $randomCardNumber;

    public function setUp(): void
    {
        parent::setUp();
        $this->tokenServiceMock = $this->createMock(TokenService::class);
        $this->httpClientMock = $this->createMock(HttpClientInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
        $this->faker = Factory::create();
        $this->randomToken = $this->faker->creditCardNumber();
        $this->randomEmail = $this->faker->email();
        $this->randomCardNumber = $this->faker->creditCardNumber;
    }

    public function testGetAllCardsForEmail(): void
    {
        $fullGoEndpointUrl = GoGatewayAdapter::GO_API_ENDPOINT
            . $this->randomEmail
            . '/cards';
        $this->tokenServiceMock->expects($this->once())
            ->method('getFullToken')
            ->with($this->equalTo($this->randomToken))
            ->willReturn($this->randomToken);
        $this->responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode(['status' => 'ok']));
        $this->httpClientMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo(GoGatewayAdapter::HTTP_METHOD_GET),
                $this->equalTo($fullGoEndpointUrl),
                $this->equalTo([
                    'headers' =>
                        ['Authorization' => $this->randomToken],
                ])
            )
        ->willReturn($this->responseMock);

        $goGateway = new GoGatewayAdapter($this->httpClientMock, $this->tokenServiceMock);
        $response = $goGateway->getAllCardsForEmail($this->randomEmail, $this->randomToken);

        $this->assertIsObject($response);
        $this->assertEquals('ok', $response->status);
    }

    public function testGetCardDataByNumber(): void
    {
        $fullGoEndpointUrlForCard = GoGatewayAdapter::GO_API_ENDPOINT
            . $this->randomEmail
            . '/cards/'
            . $this->randomCardNumber;
        $this->tokenServiceMock->expects($this->once())
            ->method('getFullToken')
            ->with($this->equalTo($this->randomToken))
            ->willReturn($this->randomToken);
        $this->responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode(['status' => 'ok']));
        $this->httpClientMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo(GoGatewayAdapter::HTTP_METHOD_GET),
                $this->equalTo($fullGoEndpointUrlForCard),
                $this->equalTo([
                    'headers' =>
                        ['Authorization' => $this->randomToken],
                ])
            )
            ->willReturn($this->responseMock);

        $goGateway = new GoGatewayAdapter($this->httpClientMock, $this->tokenServiceMock);
        $response = $goGateway->getCardDataByNumber($this->randomEmail, $this->randomCardNumber, $this->randomToken);

        $this->assertIsObject($response);
        $this->assertEquals('ok', $response->status);
    }

    public function testGetCardBalance(): void
    {
        $randomBalance = $this->faker->randomFloat(2);
        $fullGoEndpointUrlForCard = GoGatewayAdapter::GO_API_ENDPOINT
            . $this->randomEmail
            . '/cards/'
            . $this->randomCardNumber;
        $this->tokenServiceMock->expects($this->once())
            ->method('getFullToken')
            ->with($this->equalTo($this->randomToken))
            ->willReturn($this->randomToken);
        $this->responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode(['balance' => $randomBalance]));
        $this->httpClientMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo(GoGatewayAdapter::HTTP_METHOD_GET),
                $this->equalTo($fullGoEndpointUrlForCard),
                $this->equalTo([
                    'headers' =>
                        ['Authorization' => $this->randomToken],
                ])
            )
            ->willReturn($this->responseMock);

        $goGateway = new GoGatewayAdapter($this->httpClientMock, $this->tokenServiceMock);
        $response = $goGateway->getCardBalance($this->randomEmail, $this->randomCardNumber, $this->randomToken);

        $this->assertIsFloat($response);
        $this->assertEquals($randomBalance, $response);
    }

    public function testUpdateBalance(): void
    {
        $newBalance = $this->faker->randomFloat(2);
        $fullGoEndpointUrlForCard = GoGatewayAdapter::GO_API_ENDPOINT
            . $this->randomEmail
            . '/cards/'
            . $this->randomCardNumber;
        $updatedBalanceBody = ['balance' => $newBalance];

        $this->tokenServiceMock->expects($this->once())
            ->method('getFullToken')
            ->with($this->equalTo($this->randomToken))
            ->willReturn($this->randomToken);
        $this->responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode(['status' => 'ok']));
        $this->httpClientMock->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo(GoGatewayAdapter::HTTP_METHOD_PUT),
                $this->equalTo($fullGoEndpointUrlForCard),
                $this->equalTo([
                    'headers' =>
                        ['Authorization' => $this->randomToken],
                    'json' => $updatedBalanceBody,
                ])
            )
            ->willReturn($this->responseMock);

        $goGateway = new GoGatewayAdapter($this->httpClientMock, $this->tokenServiceMock);
        $response = $goGateway->updateCardBalance(
            $newBalance,
            $this->randomEmail,
            $this->randomCardNumber,
            $this->randomToken
        );

        $this->assertIsObject($response);
        $this->assertEquals('ok', $response->status);
    }
}
