<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ChangePinDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/[0-9]{4}/ui",
     *     message="Wrong pin format(must be exactly 4 digits)"
     * )
     *
     */
    public string $newPin;
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/[0-9]{16}/i",
     *     message="Wrong card Number Format"
     * )
     */
    public string $cardNumber;

    /**
     * @Assert\NotBlank()
     */
    public string $questionAnswer;
}