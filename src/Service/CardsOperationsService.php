<?php

namespace App\Service;

use App\DTO\ChangePinDTO;
use App\Entity\Account;
use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CardsOperationsService implements Interfaces\CardsOperations
{
    private TokenService $tokenService;
    private EntityManagerInterface $entityManager;
    public function __construct(TokenService $tokenService, EntityManagerInterface $entityManager)
    {
        $this->tokenService = $tokenService;
        $this->entityManager = $entityManager;
    }

    public function changePin(ChangePinDTO $changePinDto, string $token): void
    {
        $cardNumber = $changePinDto->cardNumber;
        $newPin = $changePinDto->newPin;
        $cardsRepository = $this->entityManager->getRepository(Card::class);
        /** @var Card $card */
        $card = $cardsRepository->findByCardNumber($cardNumber);
        $emailFromToken = $this->tokenService->getEmailFromGoToken($token);

        if (!$card || $card->getUserId() !== $emailFromToken) {
            throw new \DomainException('Wrong data provided', Response::HTTP_BAD_REQUEST);
        }

        $card->setPinCode($newPin);
        $this->entityManager->persist($card);
        $this->entityManager->flush();
    }
}