<?php

namespace App\Service\CardGatewayAdapter\Interfaces;

interface CardGatewayAdapter
{
    public function getAllCardsForClient(string $email, string $token): object;

    public function getCardDataByNumber(string $email, string $cardNumber, string $token): object;

    public function updateCardBalance(string $email, string $cardNumber, string $token): void;
}
