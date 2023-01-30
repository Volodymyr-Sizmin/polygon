<?php

namespace App\Service\Interfaces;

use App\DTO\PaymentServiceDTO;

interface Payment
{
    public function createFromDto(PaymentServiceDTO $dto): void;
}