<?php

namespace App\Service\Interfaces;

interface Accounts
{
    public function createAccountByEmail(string $email): string;
}