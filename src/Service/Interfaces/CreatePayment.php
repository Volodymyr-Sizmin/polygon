<?php

namespace App\Service\Interfaces;

use App\DTO\PaymentServiceDTO;

interface CreatePayment
{
    public function createFromDto(PaymentServiceDTO $dto): void;
}