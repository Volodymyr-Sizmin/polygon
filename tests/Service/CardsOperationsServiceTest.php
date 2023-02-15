<?php

namespace App\Tests\Service;

use App\DTO\ChangePinDTO;
use App\Entity\Card;
use App\Service\CardsOperationsService;
use App\Service\TokenService;
use Doctrine\ORM\EntityManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;

class CardsOperationsServiceTest extends KernelTestCase
{
    private Card $fakeCard;
    private EntityManager $entityManager;
    private TokenService $tokenService;
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->tokenService = static::getContainer()->get(TokenService::class);
        $this->faker = Factory::create();
        $this->setUpCardEntity();
    }

    public function testPinChanged(): void
    {
        $changePinDto = new ChangePinDTO();
        $changePinDto->newPin = $this->faker->randomNumber(4);
        $changePinDto->questionAnswer = $this->faker->lexify('???');
        $changePinDto->cardNumber = $this->fakeCard->getNumber();
        $token = $this->tokenService->createGoToken(['email' => $this->fakeCard->getUserId()]);

        $cardsOperationService = new CardsOperationsService($this->tokenService, $this->entityManager);
        $cardsOperationService->changePin($changePinDto, $token);

        $this->assertEquals($changePinDto->newPin, $this->fakeCard->getPinCode());
    }

    public function testWrongToken(): void
    {
        $changePinDto = new ChangePinDTO();
        $changePinDto->newPin = $this->faker->randomNumber(4);
        $changePinDto->questionAnswer = $this->faker->lexify('???');
        $changePinDto->cardNumber = $this->fakeCard->getNumber();
        $token = $this->tokenService->createGoToken(['email' => $this->faker->email()]);

        $cardsOperationService = new CardsOperationsService($this->tokenService, $this->entityManager);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Wrong data provided');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);
        $cardsOperationService->changePin($changePinDto, $token);
        $this->assertNotEquals($changePinDto->newPin, $this->fakeCard->getPinCode());
    }

    public function testWrongCard(): void
    {
        $changePinDto = new ChangePinDTO();
        $changePinDto->newPin = $this->faker->randomNumber(4);
        $changePinDto->questionAnswer = $this->faker->lexify('???');
        $changePinDto->cardNumber = $this->faker->creditCardNumber();
        $token = $this->tokenService->createGoToken(['email' => $this->fakeCard->getUserId()]);

        $cardsOperationService = new CardsOperationsService($this->tokenService, $this->entityManager);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Wrong data provided');
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);
        $cardsOperationService->changePin($changePinDto, $token);
        $this->assertNotEquals($changePinDto->newPin, $this->fakeCard->getPinCode());
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
