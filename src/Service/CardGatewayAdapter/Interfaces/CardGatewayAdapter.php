<?php

namespace App\Service\CardGatewayAdapter\Interfaces;

interface CardGatewayAdapter
{
    /**
     * @param string $email
     * @param string $token
     * @return object
     */
    public function getAllCardsForEmail(string $email, string $token): object;

    /**
     * @param string $email
     * @param string $cardNumber
     * @param string $token
     * @return object
     */
    public function getCardDataByNumber(string $email, string $cardNumber, string $token): object;

    /**
     * @param float $newBalance
     * @param string $email
     * @param string $cardNumber
     * @param string $token
     * @deprecated we will move this to our service?
     */
    public function updateCardBalance(
        float $newBalance,
        string $email,
        string $cardNumber,
        string $token
    ): object;

    /**
     * @param string $email
     * @param string $cardNumber
     * @param string $token
     * @return float
     */
    public function getCardBalance(
        string $email,
        string $cardNumber,
        string $token
    ): float;
}
