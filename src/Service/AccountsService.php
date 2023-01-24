<?php

namespace App\Service;

use App\Entity\Account;
use App\Service\Interfaces\Accounts;
use Doctrine\ORM\EntityManagerInterface;

class AccountsService implements Accounts
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createAccountByEmail(string $email): string
    {
        $account = new Account();
        $account->setUserId($email);
        $accountNumber = $this->generateAccountNumber($email);
        $account->setNumber($accountNumber);
        $account->setCurrencyId(1);
        $account->setCreatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($account);
        $this->entityManager->flush();

        return $account->getNumber();
    }

    private function generateAccountNumber(string $email): string
    {
        $generationString = $email . time();
        $hash = hash('md5', $generationString);

        return $hash;
    }
}
