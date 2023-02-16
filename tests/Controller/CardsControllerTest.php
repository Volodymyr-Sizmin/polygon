<?php

namespace App\Tests\Controller;

use App\Entity\Card;
use App\Service\TokenService;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CardsControllerTest extends WebTestCase
{
    private Generator $faker;
    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;
    private TokenService $tokenService;
    private Card $fakeCard;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $container = static::getContainer();
        $this->faker = Factory::create();
        $this->tokenService = $container->get(TokenService::class);
        $this->entityManager = $container->get(EntityManagerInterface::class);
        $this->setUpCardEntity();
    }

    /*public function testPaymentByRequisites(): void
    {
        $testEmail = 'qatest@gmail.com';
        $token = 'Bearer ' . $this->tokenService->createToken(['email' => $testEmail]);
        $method = 'POST';
        $uri = '/qatest@gmail.com/cards';
        $headers = [
            'HTTP_Authorization' => $token,
        ];

        $this->client->jsonRequest($method, $uri, [], $headers);

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }*/
    /* public function testPaymentByRequisitesFail()
     {
         $testEmail = "qatest@gmail.com";
         $token = 'Bearer ' . $this->tokenService->createToken(["email" => $testEmail]);
         $method = 'POST';
         $uri = '/service/payments/qatest@gmail.com/byrequisites';
         $headers = [
             'HTTP_Authorization' => $token
         ];
         $body = [
             "cardNumber" => "1111-1111-0000",
             "amount" => 100,
             "account_debit" => "11111111111111111111",
             "address" => "any address",
             "firstName" => "Joe",
             "secondName" => "Stive",
             "description" => "Some Description"
         ];
         $this->client->jsonRequest($method, $uri, $body, $headers);

         $this->assertSame(404, $this->client->getResponse()->getStatusCode());
     }*/

    public function testChangePinCode(): void
    {
        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $fakeAnswer = $this->faker->lexify('???????');
        $httpClientMock->expects($this->once())
            ->method('request')
            ->willReturn($responseMock);
        $responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode(['answer' => $fakeAnswer]));
        static::getContainer()->set(HttpClientInterface::class, $httpClientMock);
        $newPin = $this->faker->numerify('####');
        $requestBody = [
            'newPin' => $newPin,
            'cardNumber' => $this->fakeCard->getNumber(),
            'questionAnswer' => $fakeAnswer,
        ];
        $token = $this->tokenService->createGoToken(['email' => $this->fakeCard->getUserId()]);
        $this->client->JsonRequest(
            Request::METHOD_PUT,
            '/cards/change-pin',
            $requestBody,
            [
                'HTTP_Authorization' => $token,
            ],
        );
        $response = $this->client->getResponse();
        $responseObj = json_decode($response->getContent(), false);

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $this->assertEquals(true, $responseObj->success);
        $this->assertEquals($this->fakeCard->getPinCode(), $newPin);
    }

    public function testWrongSecretQuestionAnswer(): void
    {
        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $wrongAnswer = $this->faker->lexify('???????');
        $httpClientMock->expects($this->once())
            ->method('request')
            ->willReturn($responseMock);
        $responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode(['answer' => 'someRightAnswer']));
        static::getContainer()->set(HttpClientInterface::class, $httpClientMock);
        $newPin = $this->faker->numerify('####');
        $requestBody = [
            'newPin' => $newPin,
            'cardNumber' => $this->fakeCard->getNumber(),
            'questionAnswer' => $wrongAnswer,
        ];
        $token = $this->tokenService->createGoToken(['email' => $this->fakeCard->getUserId()]);
        $this->client->JsonRequest(
            Request::METHOD_PUT,
            '/cards/change-pin',
            $requestBody,
            [
                'HTTP_Authorization' => $token,
            ],
        );
        $response = $this->client->getResponse();
        $responseObj = json_decode($response->getContent(), false);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $this->assertJson($response->getContent());
        $this->assertEquals(false, $responseObj->success);
        $this->assertNotEquals($this->fakeCard->getPinCode(), $newPin);
    }

    private function setUpCardEntity(): void
    {
        $fakeEmail = $this->faker->email();
        $fakeIBAN = $this->faker->iban('GB');
        $fakeCardNumber = $this->faker->creditCardNumber();

        $this->fakeCard = new Card();
        $this->fakeCard->setCreatedAt(new \DateTimeImmutable());
        $this->fakeCard->setUpdatedAt(new \DateTimeImmutable());
        $this->fakeCard->setExpiryDate(new \DateTimeImmutable());
        $this->fakeCard->setNumber($fakeCardNumber);
        $this->fakeCard->setUserId($fakeEmail);
        $this->fakeCard->setName($this->faker->lexify('?????????'));
        $this->fakeCard->setCardTypeName($this->faker->lexify('?????? ??????'));
        $this->fakeCard->setStatus('active');
        $this->fakeCard->setAnswerAttempts(3);
        $this->fakeCard->setAccountNumber($fakeIBAN);
        $this->fakeCard->setCurrencyName('GBP');
        $this->fakeCard->setPinCode($this->faker->randomNumber(4));
        $this->entityManager->persist($this->fakeCard);
        $this->entityManager->flush();
    }
}
