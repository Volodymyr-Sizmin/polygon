<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UtilityPaymentDTO
{
    public string $payerCardNumber = '';
    /**
     * @Assert\Expression(
     *     expression="this.payerCardNumber != '' ||  value != ''",
     *     message="Either payer Card Number or Account Number must be provided"
     * )
     */
    public string $payerAccountNumber = '';
    /**
     * @Assert\NotBlank()
     */
    public int $utilityProviderId;
    public string $subject;
    /**
     * @Assert\NotBlank()
     */
    public float $paymentAmount;

}