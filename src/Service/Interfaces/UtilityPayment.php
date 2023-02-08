<?php

namespace App\Service\Interfaces;

use App\DTO\UtilityPaymentDTO;

interface UtilityPayment
{
    public function pay(UtilityPaymentDTO $utilityPaymentDTO, ?string $token);
}