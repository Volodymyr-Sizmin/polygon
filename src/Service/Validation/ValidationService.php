<?php

declare(strict_types=1);

namespace App\Service\Validation;

use App\Interfaces\Validation\ValidationInterface;
use App\Exception\ValidationServiceException;

class ValidationService implements ValidationInterface
{
    /**
     * @param string $field
     * @param $lengthMin
     * @param $lengthMax
     * @return bool
     * @throws ValidationServiceException
     **/
    public function smallField($field, $lengthMin, $lengthMax)
    {
        $length = mb_strlen($field);
        self::validationLength($length, $lengthMin, $lengthMax);
        if (
            preg_match("/(^\.|\.$|\.{2,}| {2,})/", $field) or
            !preg_match("/^[ a-zA-Zа-яёА-ЯЁ0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№~\.]+$/u", $field)
        ) {
            throw new ValidationServiceException('Can contain letters, numbers,
             !@#$%^&*()_-=+;:\'\"?,<>[]{}\|/№!~\' symbols, 
             and dot can\'t use like the first and last symbol and also can\'t be repeated consecutively');
        }
        return true;
    }

    /**
     * @param $field
     * @param $lengthMin
     * @param $lengthMax
     * @return bool
     * @throws ValidationServiceException
     **/
    public function bigField($field, $lengthMin, $lengthMax)
    {
        $length = mb_strlen($field);
        self::validationLength($length, $lengthMin, $lengthMax);
        if (
            preg_match("/(^\.|\.$|\.{2,}| {2,})/", $field) or
            !preg_match("/^[ a-zA-Zа-яёА-ЯЁ0-9!#$%&‘*+\—\\\|\/=?\-^_`\x27{\}~!»№;%:()[\]<>,\.]+$/u", $field)
        ) {
            throw new ValidationServiceException('Can contain letters, numbers, 
            !#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, 
            and dot can\'t use like the first and last symbol and also can\'t be repeated consecutively');
        }
        return true;
    }

    /**
     * @param $field
     * @param $lengthMin
     * @param $lengthMax
     * @return bool
     * @throws ValidationServiceException
     **/
    public function password($field, $lengthMin, $lengthMax)
    {
        $length = mb_strlen($field);
        self::validationLength($length, $lengthMin, $lengthMax);
        if (
            preg_match("/(^\.|\.$|\.{2,})/", $field) or
            !preg_match("/(^[a-zA-Zа-яёА-ЯЁ0-9!#$%&*+\—\\\|\/=?\-^_`
            '{\}~!»№;%:()[\]<>,]+\.{0,1}[a-zA-Zа-яёА-ЯЁ0-9!#$%&*+\—\\\|\/=?\-^_
            `'{\}~!»№;%:()[\]<>,]+$|^[a-zA-Zа-яёА-ЯЁ0-9!#$%&*+\—\\\|\/=?\-^_`'{\}~!»№;%:()[\]<>,]+$)/u", $field)
        ) {
            throw new ValidationServiceException('Can contain letters, numbers, 
            !#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last');
        }
        return true;
    }

    /**
     * @param $field
     * @param $lengthMin
     * @param $lengthMax
     * @return bool
     * @throws ValidationServiceException
     **/
    public function email($field, $lengthMin, $lengthMax)
    {
        $length = mb_strlen($field);
        if (
            $length < $lengthMin or
            $length > $lengthMax or
            preg_match("/(^\.|\.$|[\.]@|@[\.]|\.{2,}$)/", $field) or
            !preg_match("/^[a-z0-9!#$%&‘*+\-\\\=?^_'{\}\|~]+@[a-z0-9\-]+\.[a-z0-9\-]+$/", $field)
        ) {
            throw new ValidationServiceException('Invalid e-mail Address length');
        }
        return true;
    }

    /**
     * @param $field
     * @return bool
     * @throws ValidationServiceException
     **/
    public function cardNumber($field)
    {
        if (!preg_match("/^[0-9]{16}$/", $field)) {
            throw new ValidationServiceException("Wrong card number");
        }
        return true;
    }

    /**
     * @param $field
     * @return bool
     * @throws ValidationServiceException
     **/
    public function expiryDate($field)
    {
        $field = str_replace('/', '', $field);
        if (preg_match('/0-9{4}/', $field)) {
            throw new ValidationServiceException("Wrong expiry");
        }
        $expires = \DateTime::createFromFormat('my', $field, new \DateTimeZone('+00:00'));
        $now = new \DateTime();
        if ($expires < $now) {
            throw new ValidationServiceException("Wrong expiry");
        }
        return true;
    }

    /**
     * @param $field
     * @return bool
     * @throws ValidationServiceException
     **/
    public function cvc($field)
    {
        if (!preg_match("/^[0-9]{3}$/", $field)) {
            throw new ValidationServiceException("Wrong cvc number");
        }
        return true;
    }

    /**
     * @param $field
     * @return bool
     * @throws ValidationServiceException
     **/
    public function cardholderName($field)
    {
        if (!preg_match("/^[ A-Z\.\-]{3,}$/", $field)) {
            throw new ValidationServiceException("Can contain letters, hyphen and dot");
        }
        return true;
    }

    /**
     * @param $length
     * @param $lengthMin
     * @param $lengthMax
     * @return bool
     * @throws ValidationServiceException
     */
    public function validationLength($length, $lengthMin, $lengthMax)
    {
        if ($length < $lengthMin) {
            throw new ValidationServiceException("Must be $lengthMin characters or more");
        }
        if ($length > $lengthMax) {
            throw new ValidationServiceException("Must be $lengthMax characters or less");
        }
        return true;
    }
}