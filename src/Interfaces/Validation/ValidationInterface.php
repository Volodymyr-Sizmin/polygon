<?php

declare(strict_types=1);

namespace App\Interfaces\Validation;

/**
 * Interface ValidationInterface
 *
 * Here we have 8 methods from validation map https://wiki.andersenlab.com/display/POL/Validation+Map
 * To use this methods, use every time "try catch" to catch Exceptions
 * If validation confirmed method return boolean TRUE
 * @package App\Interfaces\Validation
 */
interface ValidationInterface
{
    /**
     * In param put type of field "Small field" from Request
     *
     * @param $field
     * @param $rageMin
     * @param $rageMax
     * @return bool
     * @throws ValidationServiceException
     */
    public function smallField($field, $rageMin, $rageMax);

    /**
     * In param put type of field "Big field" from Request
     *
     * @param $field
     * @param $rageMin
     * @param $rageMax
     * @return bool
     * @throws ValidationServiceException
     */
    public function bigField($field, $rageMin, $rageMax);

    /**
     * In param put type of field "Password" from Request
     *
     * @param $field
     * @param $rageMin
     * @param $rageMax
     * @return bool
     * @throws ValidationServiceException
     */
    public function password($field, $rageMin, $rageMax);

    /**
     * In param put type of field "Email" from Request
     *
     * @param $field
     * @param $rageMin
     * @param $rageMax
     * @return bool
     * @throws ValidationServiceException
     */
    public function email($field, $rageMin, $rageMax);

    /**
     * In param put type of field "Card Number" from Request
     *
     * @param $field
     * @return bool
     * @throws ValidationServiceException
     */
    public function cardNumber($field);

    /**
     * In param put type of field "Expiry Date" from Request
     * This method take param only in this format like "01/22" -  month/year
     *
     * @param $field
     * @return bool
     * @throws ValidationServiceException
     */
    public function expiryDate($field);

    /**
     * In param put type of field "CVC" from Request
     *
     * @param $field
     * @return bool
     * @throws ValidationServiceException
     */
    public function cvc($field);

    /**
     * In param put type of field "Сardholder name and Soname" from Request
     *
     * @param $field
     * @return bool
     * @throws ValidationServiceException
     */
    public function cardholderName($field);

    /**
     * This method you can use every were you want to check Length.
     * In first parameter we put length of some thing
     * Second parameter min length and third max length
     * In result we take ValidationServiceException with message or bool TRUE
     * which one confirm the validation
     * @param $length
     * @param $lengthMin
     * @param $lengthMax
     * @return bool
     * @throws ValidationServiceException
     */
    public function validationLength($length, $lengthMin, $lengthMax);
}