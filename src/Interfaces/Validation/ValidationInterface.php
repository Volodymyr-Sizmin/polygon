<?php

declare(strict_types=1);

namespace App\Interfaces\Validation;

/**
 * Interface ValidationInterface.
 *
 * Here we have 8 methods from validation map https://wiki.andersenlab.com/display/POL/Validation+Map
 * To use this methods, use every time "try catch" to catch Exceptions
 * If validation confirmed method return boolean TRUE
 */
interface ValidationInterface
{
    /**
     * In param put type of field "Small field" from Request.
     *
     * @param $lengthMin
     *
     * @throws ValidationServiceException
     */
    public function smallField(string $field, int $lengthMin, int $lengthMax): bool;

    /**
     * In param put type of field "Big field" from Request.
     *
     * @throws ValidationServiceException
     */
    public function bigField(string $field, int $lengthMin, int $lengthMax): bool;

    /**
     * In param put type of field "Password" from Request.
     *
     * @throws ValidationServiceException
     */
    public function password(string $field, int $lengthMin, int $lengthMax): bool;

    /**
     * In param put type of field "Email" from Request.
     *
     * @throws ValidationServiceException
     */
    public function email(string $field, int $lengthMin, int $lengthMax): bool;

    /**
     * In param put type of field "Card Number" from Request.
     *
     * @throws ValidationServiceException
     */
    public function cardNumber(string $field): bool;

    /**
     * In param put type of field "Expiry Date" from Request
     * This method take param only in this format like "01/22" -  month/year.
     *
     * @throws ValidationServiceException
     */
    public function expiryDate(string $field): bool;

    /**
     * In param put type of field "CVC" from Request.
     *
     * @throws ValidationServiceException
     */
    public function cvc(string $field): bool;

    /**
     * In param put type of field "Сardholder name and Soname" from Request.
     *
     * @throws ValidationServiceException
     */
    public function cardholderName(string $field): bool;

    /**
     * This method you can use every were you want to check Length.
     * In first parameter we put length of some thing
     * Second parameter min length and third max length
     * In result we take ValidationServiceException with message or bool TRUE
     * which one confirm the validation.
     *
     * @param $length
     * @param $lengthMin
     * @param $lengthMax
     *
     * @throws ValidationServiceException
     */
    public function validationLength(int $length, int $lengthMin, int $lengthMax): bool;
}
