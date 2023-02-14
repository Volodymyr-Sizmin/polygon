<?php

namespace App\Service;

use App\DTO\FastPaymentDTO;
use App\Entity\FastPayments;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FastPaymentService
{
    protected TokenService $tokenService;
    protected ManagerRegistry $doctrine;
    protected HttpClientInterface $client;

    const POLYGON_APPLICATION_GO = 'https://polygon-application.andersenlab.dev/';

    public function __construct(HttpClientInterface $client, TokenService $tokenService, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->tokenService = $tokenService;
        $this->doctrine = $doctrine;
    }

    public function getFastPayments(FastPaymentDTO $dto): array
    {
        $email = $this->tokenService->getEmailFromToken($dto->token);

        return $this->doctrine->getRepository(FastPayments::class)->findBy(['user_email' => $email]);
    }

    public function getFastPaymentInfo(FastPaymentDTO $dto): object
    {
        $email = $this->tokenService->getEmailFromToken($dto->token);

        $fastPayment = $this->doctrine->getRepository(FastPayments::class)->find($dto->templateId);

        if (!$fastPayment || $fastPayment->getUserEmail() !== $email) {
            throw new \DomainException("No template found with id $dto->templateId ", 404);
        }

        return $fastPayment;
    }

    public function updateFastPayment(FastPaymentDTO $dto): array
    {
        $email = $this->tokenService->getEmailFromToken($dto->token);

        $entityManager = $this->doctrine->getManager();
        $fastPayment = $entityManager->getRepository(FastPayments::class)->find($dto->templateId);

        if (!$fastPayment || $fastPayment->getUserEmail() !== $email) {
            throw new \DomainException("No template found with id $dto->templateId", 404);
        }

        if (!$dto->name) {
            throw new \DomainException("Empty input", 404);
        }

        $fastPayment->setName($dto->name);
        $fastPayment->setCardNumber($dto->cardNumber);
        $fastPayment->setPaymentReason($dto->paymentReason);
        $fastPayment->setAmount($dto->amount);
        $fastPayment->setAccountNumber($dto->accountNumber);
        $fastPayment->setAddress($dto->address);
        $fastPayment->setRecepientName($dto->recepientName);
        $entityManager->flush();

        return ['success' => true, 'message' => 'Payment template was successfully updated'];
    }

    public function deleteTemplate(FastPaymentDTO $dto): array
    {
        $email = $this->tokenService->getEmailFromToken($dto->token);

        $em = $this->doctrine->getManager();
        $fastPayment = $em->getRepository(FastPayments::class)->find($dto->templateId);
        if (!$fastPayment || $fastPayment->getUserEmail() !== $email) {
            throw new \DomainException("No template found with id $dto->templateId", 404);
        }

        $em->remove($fastPayment);
        $em->flush();
        return ["success" => true, 'body' => [
            'message' => 'Payment template was successfully deleted']];
    }

    public function updateBalance(FastPaymentDTO $dto, object $fastPayment): bool
    {
        $email = $fastPayment->getUserEmail();
        $cardNumber = $fastPayment->getCardNumber();
        $amount = $fastPayment->getAmount();

        $response = $this->client->request('GET', self::POLYGON_APPLICATION_GO . "cards_service/$email/cards/$cardNumber", [
            'headers' => [
                'Authorization' => $dto->token,
            ]
        ]);
        $content = json_decode($response->getContent());
        $balance = $content->balance;

        if ($balance < $dto->amount) {
            throw new \DomainException("You don't have enough money on your card", 200);
        }

        $newBalance = $balance - $amount;
        $this->client->request('PUT', self::POLYGON_APPLICATION_GO . "cards_service/{$email}/cards/{$cardNumber}", [
            'headers' => [
                'Authorization' => $dto->token,
            ],
            'json' => ['balance' => $newBalance]
        ]);

        return true;
    }

    public function makePayment(FastPaymentDTO $dto): array
    {
        $email = $this->tokenService->getEmailFromToken($dto->token);
        $em = $this->doctrine->getManager();
        $fastPayment = $em->getRepository(FastPayments::class)->find($dto->templateId);
        if (!$fastPayment || $fastPayment->getUserEmail() !== $email) {
            throw new \DomainException("No template found with id $dto->templateId", 404);
        }
        return ["success" => true, 'body' => [
            'message' => 'Payment successful']];
    }
}