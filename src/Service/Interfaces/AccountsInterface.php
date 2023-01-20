<?php

namespace App\Service\Interfaces;

interface AccountsInterface
{
    public function createAccountByEmail(string $email): string;
}