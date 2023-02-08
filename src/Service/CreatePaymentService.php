<?php

namespace App\Service;

use App\DTO\PaymentServiceDTO;
use App\Entity\Payment;
use Doctrine\ORM\EntityManagerInterface;

class CreatePaymentService implements Interfaces\CreatePayment
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function createFromDto(PaymentServiceDTO $dto): void
    {
        $payment = new Payment();
        $payment->setUserId($dto->getUserId());
        $payment->setAccountCreditId($dto->getAccountCreditId());
        $payment->setAccountDebitId($dto->getAccountDebitId());
        $payment->setAmount($dto->getAmount());
        $payment->setCurrencyId($dto->getCurrencyId());
        $payment->setSubject($dto->getSubject());
        $payment->setTypeId($dto->getTypeId());
        $payment->setStatusId($dto->getStatusId());
        $payment->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($payment);
        $this->entityManager->flush();
    }
}