<?php

namespace App\Service\Interfaces;

use App\Entity\Account;

interface MoneyTransfer
{
    public function transferBetweenAccounts(Account $payer, Account $receiver, float $amount, string $token): void;
    public function takeMoneyFromAccount(Account $account, float $amount, string $token): void;
    public function putMoneyOnAccount(Account $account, float $amount, string $token): void;


}
