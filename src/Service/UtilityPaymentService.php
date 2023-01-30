<?php

namespace App\Service;

use App\DTO\UtilityPaymentByCardDTO;
use App\DTO\UtilityPaymentDTO;
use App\Entity\Account;
use App\Entity\UtilitiesProvider;
use App\Repository\AccountRepository;
use App\Service\Interfaces\MoneyTransfer;
use App\Service\Interfaces\UtilityPayment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class UtilityPaymentService implements UtilityPayment
{
    private EntityManagerInterface $entityManager;
    private MoneyTransfer $moneyTransfer;

    public function __construct(
        EntityManagerInterface $entityManager,
        MoneyTransfer $moneyTransfer
    ) {
        $this->entityManager = $entityManager;
        $this->moneyTransfer = $moneyTransfer;
    }

    public function pay(UtilityPaymentDTO $utilityPaymentDTO, ?string $token): void
    {
        /**@var AccountRepository $accountRepository*/
        $accountRepository = $this->entityManager->getRepository(Account::class);
        $payerAccount = $this->getPayerAccountFromDto($utilityPaymentDTO, $accountRepository);
        $utilityProvider = $this->entityManager->find(UtilitiesProvider::class, $utilityPaymentDTO->utilityProviderId);
        $utilityProviderAccount = $accountRepository->find($utilityProvider->getAccount());
        $amount = $utilityPaymentDTO->paymentAmount;

        $this->assertAccountsExist($payerAccount, $utilityProviderAccount);
        $this->moneyTransfer->transferBetweenAccounts($payerAccount, $utilityProviderAccount, $amount, $token);
    }

    private function getPayerAccountFromDto(
        UtilityPaymentDTO $utilityPaymentDTO,
        AccountRepository $repository
    ): ?Account {
        $cardNumber = $utilityPaymentDTO->payerCardNumber;
        $accountNumber = $utilityPaymentDTO->payerAccountNumber;

        return $cardNumber ?
            $repository->findByCardNumber($cardNumber)
            :
            $repository->findByAccountNumber($accountNumber);
    }

    private function assertAccountsExist(?Account $payer, ?Account $provider): void
    {
        $errors = [];
        if (!$payer) {
            $errors[] = 'Payer account not found';
        }
        if (!$provider) {
            $errors[] = 'Utility provider account not found';
        }

        if ($errors) {
            $errors = implode(' ', $errors);
            throw new \DomainException($errors, Response::HTTP_ACCEPTED);
        }
    }
}
