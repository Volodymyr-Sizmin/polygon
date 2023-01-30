<?php

namespace App\Service;

use App\Entity\Account;
use App\Service\CardGatewayAdapter\Interfaces\CardGatewayAdapter;
use Symfony\Component\HttpFoundation\Response;

class MoneyTransferService implements Interfaces\MoneyTransfer
{
    private CardGatewayAdapter $cardGatewayAdapter;

    public function __construct(CardGatewayAdapter $cardGatewayAdapter)
    {
        $this->cardGatewayAdapter = $cardGatewayAdapter;
    }

    public function transferBetweenAccounts(Account $payer, Account $receiver, float $amount, string $token): void
    {
        $this->takeMoneyFromAccount($payer, $amount, $token);
        $this->putMoneyOnAccount($receiver, $amount, $token);
    }

    private function takeMoneyFromAccount(Account $account, float $amount, string $token): void
    {
        $accountCardNumber = $account->getCardNumber();
        $balance = $this->cardGatewayAdapter->getCardBalance($account->getUserId(), $accountCardNumber, $token);

        $this->assertCardBalanceSufficient($balance, $amount, $accountCardNumber);
        $resultingAmount = ($balance * 100 - $amount * 100) / 100;
        $updateBalanceResponse = $this->cardGatewayAdapter->updateCardBalance(
            $resultingAmount,
            $account->getUserId(),
            $account->getCardNumber(),
            $token
        );

        $this->assertAccountOperationSuccessful($updateBalanceResponse);
    }

    private function putMoneyOnAccount(Account $account, float $amount, string $token): void
    {
        $balance = $this->cardGatewayAdapter->getCardBalance($account->getUserId(), $account->getCardNumber(), $token);
        $resultingAmount = ($balance * 100 + $amount * 100) / 100;

        $updateBalanceResponse = $this->cardGatewayAdapter->updateCardBalance(
            $resultingAmount,
            $account->getUserId(),
            $account->getCardNumber(),
            $token
        );

        $this->assertAccountOperationSuccessful($updateBalanceResponse);
    }

    private function assertAccountOperationSuccessful(object $updateBalanceResponse): void
    {
        $isSuccessful = $updateBalanceResponse->success ?? '';

        if (!$isSuccessful) {
            $errorMessage = $updateBalanceResponse->message ?? 'Payment Error while paying';
            throw new \DomainException($errorMessage, Response::HTTP_ACCEPTED);
        }
    }

    private function assertCardBalanceSufficient(float $balance, float $paymentAmount, string $cardNumber): void
    {
        if ($balance < $paymentAmount) {
            $errorMessage = "Insufficient funds on card {$cardNumber}";
            throw new \DomainException($errorMessage, Response::HTTP_ACCEPTED);
        }
    }
}
