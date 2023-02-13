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
        $this->assertCardOperationPossible($card, $token);
        $card->setPinCode($newPin);
        $this->entityManager->persist($card);
        $this->entityManager->flush();
    }

    private function assertCardOperationPossible(?Card $card, string $token): void
    {
        if(!$card){
            throw new \DomainException('No Card Found', Response::HTTP_NOT_FOUND);
        }

        $accountRepository = $this->entityManager->getRepository(Account::class);
        /** @var Account $account */
        $account = $accountRepository->findByCardNumber($card->getNumber());
        $emailFromToken = $this->tokenService->getEmailFromGoToken($token);

        if (!$account || $account->getUserId() !== $emailFromToken) {
            throw new UnauthorizedHttpException("Incorrect Token", Response::HTTP_UNAUTHORIZED);
        }
    }
}