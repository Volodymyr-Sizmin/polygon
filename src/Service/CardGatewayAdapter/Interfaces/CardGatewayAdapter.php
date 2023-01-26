<?php

namespace App\Service\CardGatewayAdapter\Interfaces;

interface CardGatewayAdapter
{
    /**
     * @param string $email
     * @param string $token
     * @return object
     */
    public function getAllCardsForClient(string $email, string $token): object;

    /**
     * @param string $email
     * @param string $cardNumber
     * @param string $token
     * @return object
     */
    public function getCardDataByNumber(string $email, string $cardNumber, string $token): object;

    /**
     * @deprecated we will move this to our service?
     * @param float $newBalance
     * @param string $email
     * @param string $cardNumber
     * @param string $token
     */
    public function updateCardBalance(float $newBalance, string $email, string $cardNumber, string $token): void;
}
