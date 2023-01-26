<?php

namespace App\Service;

use App\DTO\FastPaymentDTO;
use App\Entity\FastPayments;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class FastPaymentService
{
    protected TokenService $tokenService;
    protected  CardBalanceService $cardBalanceService;

    public function __construct(TokenService $tokenService, CardBalanceService $cardBalanceService)
    {
        $this->tokenService = $tokenService;
        $this->cardBalanceService = $cardBalanceService;
    }

   public function getFastPayments($dto, $doctrine):array
    {
       $email = $this->tokenService->getEmailFromToken($dto->token);

       $templatesList = $doctrine->getRepository(FastPayments::class)->findBy(['user_email' => $email]);
       if(!$templatesList){
           throw new \DomainException('No templates found', 404);
       }
       return $templatesList;
    }

   public function getFastPaymentInfo(FastPaymentDTO $dto, ManagerRegistry $doctrine):array
    {
        $email = $this->tokenService->getEmailFromToken($dto->token);
        $cards = $this->cardBalanceService->showCards($email, $dto->token);
        $fast_payment =  $doctrine->getRepository(FastPayments::class)->find($dto->templateId);

        if (!$fast_payment || $fast_payment->getUserEmail() !== $email) {
            throw new \DomainException("No template found with id  $dto->templateId ", 404);
        }

       return [$fast_payment, $cards];
    }

   public function updateFastPayment($dto, $doctrine):array
       {
           $email = $this->tokenService->getEmailFromToken($dto->token);

           $entityManager = $doctrine->getManager();
           $fast_payment = $entityManager->getRepository(FastPayments::class)->find($dto->templateId);

            if (!$fast_payment || $fast_payment->getUserEmail() !== $email) {
                throw new \DomainException("No template found with id  $dto->templateId ", 404);
            }

            if (!$dto->name) {
                throw new \DomainException("Empty input ", 404);
            }

            $fast_payment->setName($dto->name);
            $fast_payment->setCardNumber($dto->cardNumber);
            $fast_payment->setPaymentReason($dto->paymentReason);
            $fast_payment->setAmount($dto->amount);
            $fast_payment->setAccountNumber($dto->accountNumber);
            $fast_payment->setAddress($dto->address);
            $fast_payment->setRecepientName($dto->recepientName);
            $entityManager->flush();
            return ['success' => true, 'message' => 'Payment template was successfully updated'];
    }

    public function deleteTemplate(FastPaymentDTO $dto, ManagerRegistry $doctrine):array
    {
        $email = $this->tokenService->getEmailFromToken($dto->token);

        $em = $doctrine->getManager();
        $fast_payment = $em->getRepository(FastPayments::class)->find($dto->templateId);
        if (!$fast_payment || $fast_payment->getUserEmail() !== $email) {
            throw new \DomainException("No template found with id  $dto->templateId ", 404);
        }

        $em->remove($fast_payment);
        $em->flush();
        return  ["success" => true, 'body' => [
            'message' => 'Payment template was successfully deleted']];
    }
}
