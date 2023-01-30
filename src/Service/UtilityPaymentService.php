<?php

namespace App\Service;

use App\DTO\PaymentServiceDTO;
use App\DTO\UtilityPaymentDTO;
use App\Entity\Account;
use App\Entity\Currency;
use App\Entity\UtilitiesProvider;
use App\Repository\AccountRepository;
use App\Service\Interfaces\MoneyTransfer;
use App\Service\Interfaces\CreatePayment;
use App\Service\Interfaces\UtilityPayment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class UtilityPaymentService implements UtilityPayment
{
    private const UTILITY_PAYMENT_TYPE_ID = 3;
    private const UTILITY_PAYMENT_STATUS_ID = 1; //TODO: refactor this!!!

    private EntityManagerInterface $entityManager;
    private MoneyTransfer $moneyTransfer;
    private $paymentService;

    public function __construct(
        EntityManagerInterface $entityManager,
        MoneyTransfer $moneyTransfer,
        CreatePayment $paymentService
    ) {
        $this->entityManager = $entityManager;
        $this->moneyTransfer = $moneyTransfer;
        $this->paymentService = $paymentService;
    }

    public function pay(UtilityPaymentDTO $utilityPaymentDTO, ?string $token): void
    {
        /**@var AccountRepository $accountRepository*/
        $accountRepository = $this->entityManager->getRepository(Account::class);
        $payerAccount = $this->getPayerAccountFromDto($utilityPaymentDTO, $accountRepository);
        $utilityProviderAccount = $this->getProviderAccountFromDto($utilityPaymentDTO, $accountRepository);
        $amount = $utilityPaymentDTO->paymentAmount;

        $this->assertAccountsExist($payerAccount, $utilityProviderAccount);
        $this->moneyTransfer->transferBetweenAccounts($payerAccount, $utilityProviderAccount, $amount, $token);
        $this->savePayment($utilityPaymentDTO);
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

    private function getProviderAccountFromDto(
        UtilityPaymentDTO $utilityPaymentDTO,
        AccountRepository $accountRepository
    ): ?Account {
        $utilityProvider = $this->entityManager->find(UtilitiesProvider::class, $utilityPaymentDTO->utilityProviderId);
        $utilityProviderAccount = $accountRepository->find($utilityProvider->getAccount());

        return $utilityProviderAccount;
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

    private function savePayment(UtilityPaymentDTO $utilityPaymentDTO): void
    {
        $accountRepository = $this->entityManager->getRepository(Account::class);
        $currencyRepository = $this->entityManager->getRepository(Currency::class);
        $payerAccount = $this->getPayerAccountFromDto($utilityPaymentDTO, $accountRepository);
        $providerAccount = $this->getProviderAccountFromDto($utilityPaymentDTO, $accountRepository);
        $currencyId = $currencyRepository->findOneBy(['name' => $utilityPaymentDTO->currency])->getId();

        $paymentDTO = new PaymentServiceDTO();
        $paymentDTO->setUserId($payerAccount->getUserId());
        $paymentDTO->setAccountDebitId($payerAccount->getNumber());
        $paymentDTO->setAccountCreditId($providerAccount->getNumber());
        $paymentDTO->setAmount($utilityPaymentDTO->paymentAmount);
        $paymentDTO->setCurrencyId($currencyId);
        $paymentDTO->setTypeId(self::UTILITY_PAYMENT_TYPE_ID);
        $paymentDTO->setSubject($utilityPaymentDTO->subject);
        $paymentDTO->setCardDebitNumber($payerAccount->getCardNumber());
        $paymentDTO->setCardCreditNumber($providerAccount->getCardNumber());
        $paymentDTO->setStatusId(self::UTILITY_PAYMENT_STATUS_ID);

        $this->paymentService->createFromDto($paymentDTO);
    }
}
