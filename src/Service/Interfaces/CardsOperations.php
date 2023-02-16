<?php

namespace App\Service\Interfaces;

use App\DTO\ChangePinDTO;

interface CardsOperations
{
    public function changePin(ChangePinDTO $changePinDto, string $token): void;
}