<?php

namespace App\Interfaces\Validation;

/**
 * Interface ValidationInterface
 *
 * Here we have 8 methods from validation map https://wiki.andersenlab.com/display/POL/Validation+Map
 * It is very simple to use. You just call one of this methods, give field, which one you want to check,
 * and in answer if you see string of this field, it is mean everything is cool, the validation was passed.
 * In case if the validation was not passed you get answer in array, with all errors.
 *
 * Long story short, if after call, you receive
 * STRING - validation was passed
 * if
 * ARRAY - validation was not passed
 *
 * @package App\Interfaces\Validation
 */
interface ValidationInterface
{
    /**
     * In param put type of field "Small field" from Request
     *
     * @param $field
     * @return array|string
     */
    public function smallField($field);

    /**
     * In param put type of field "Big field" from Request
     *
     * @param $field
     * @return array|string
     */
    public function bigField($field);

    /**
     * In param put type of field "Password" from Request
     *
     * @param $field
     * @return array|string
     */
    public function password($field);

    /**
     * In param put type of field "Email" from Request
     *
     * @param $field
     * @return array|string
     */
    public function email($field);

    /**
     * In param put type of field "Card Number" from Request
     *
     * @param $field
     * @return array|string
     */
    public function cardNumber($field);

    /**
     * In param put type of field "Expiry Date" from Request
     * This method take param only in this format like "01/22" -  month/year
     *
     * @param $field
     * @return array|string
     */
    public function expiryDate($field);

    /**
     * In param put type of field "CVC" from Request
     *
     * @param $field
     * @return array|string
     */
    public  function cvc($field);

    /**
     * In param put type of field "Сardholder name and Soname" from Request
     *
     * @param $field
     * @return array|string
     */
    public function cardholderName($field);
}