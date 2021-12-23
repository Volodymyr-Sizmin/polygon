<?php

namespace App\Service\Validation;

use App\Interfaces\Validation\ValidationInterface;

class ValidationService implements  ValidationInterface
{
    /**
     * @param $field
     * @return array|string
    **/
    public function smallField($field)
    {
        $errors = [];
        $field = trim($field);
        $length = mb_strlen($field);
        if($length < 2)
        {
            $errors[] = 'Must be 2 characters or more';
        }
        if($length > 60)
        {
            $errors[] = 'Must be 60 characters or less';
        }
        if(preg_match("/(^\.|\.$|\.{2,})/", $field) OR !preg_match("/^[ a-zA-Zа-яёА-ЯЁ0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№~\.]+$/u", $field))
        {
            $errors[] = 'Can contain letters, numbers, !@#$%^&*()_-=+;:\'\"?,<>[]{}\|/№!~\' symbols, and one dot not first or last';
            return $errors;
        }
        if(empty($errors))
        {
            return $field;
        }

        return $errors;
    }

    /**
     * @param $field
     * @return array|string
     **/
    public function bigField($field)
    {
        $errors = [];
        $field = trim($field);
        $length = mb_strlen($field);
        if($length < 2)
        {
            $errors[] = 'Must be 2 characters or more';
        }
        if($length > 255)
        {
            $errors[] = 'Must be 255 characters or less';
        }
        if(preg_match("/(^\.|\.$|\.{2,})/", $field) OR !preg_match("/^[ a-zA-Zа-яёА-ЯЁ0-9!#$%&‘*+\—\\\|\/=?\-^_`\x27{\}~!»№;%:()[\]<>,\.]+$/u", $field))
        {
            $errors[] = 'Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last';
            return $errors;
        }
        if(empty($errors))
        {
            return $field;
        }

        return $errors;
    }

    /**
     * @param $field
     * @return array|string
     **/
    public function password($field)
    {
        $errors = [];
        $field = trim($field);
        $length = mb_strlen($field);
        if($length < 8)
        {
            $errors[] = "Must be 8 characters or more";
        }
        if($length > 32)
        {
            $errors[] = "Must be 32 characters or less";
        }
        if(preg_match("/(^\.|\.$|\.{2,})/", $field) OR !preg_match("/(^[a-zA-Zа-яёА-ЯЁ0-9!#$%&*+\—\\\|\/=?\-^_`'{\}~!»№;%:()[\]<>,]+\.{0,1}[a-zA-Zа-яёА-ЯЁ0-9!#$%&*+\—\\\|\/=?\-^_`'{\}~!»№;%:()[\]<>,]+$|^[a-zA-Zа-яёА-ЯЁ0-9!#$%&*+\—\\\|\/=?\-^_`'{\}~!»№;%:()[\]<>,]+$)/u", $field))
        {
            $errors[] = 'Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last';
            return $errors;
        }
        if(empty($errors))
        {
            return $field;
        }
        return $errors;
    }

    /**
     * @param $field
     * @return array|string
     **/
    public function email($field)
    {
        $errors = [];
        $field = trim($field);
        $field = mb_strtolower($field);
        $length = mb_strlen($field);
        if($length < 3 OR $length > 32 OR preg_match("/(^\.|\.$|[\.]@|@[\.]|\.{2,}$)/",$field) OR !preg_match("/^[a-z0-9!#$%&‘*+\-\\\=?^_'{\}\|~]+@[a-z0-9\-]+\.[a-z0-9\-]+$/",$field))
        {
            $errors[] = 'Invalid e-mail Address length';
            return $errors;
        }
        return $field;
    }

    /**
     * @param $field
     * @return array|string
     **/
    public function cardNumber($field)
    {
        $field = trim($field);
        $pattern = "/^[0-9]{16}$/";
        if (!preg_match($pattern, $field))
        {
            return ["Wrong card number"];
        }

        return $field;
    }

    /**
     * @param $field
     * @return array|string
     **/
    public function expiryDate($field)
    {
        $field = trim($field);
        $field = str_replace('/','',$field);
        if(preg_match('/0-9{4}/', $field))
        {
            $errors[] = "Wrong expiry";
            return $errors;
        }
        $expires = \DateTime::createFromFormat('my', $field, new \DateTimeZone('+00:00'));
        $now = new \DateTime();
        if ($expires < $now) {
            $errors[] = "Wrong expiry";
            return $errors;
        }
        return $field;
    }

    /**
     * @param $field
     * @return array|string
     **/
    public function cvc($field)
    {
        $field = trim($field);
        if (!preg_match("/^[0-9]{3}$/", $field))
        {
            return ["Wrong cvc number"];
        }
        return $field;
    }

    /**
     * @param $field
     * @return array|string
     **/
    public function cardholderName($field)
    {
        $field = trim($field);
        $field = mb_strtoupper($field);
        if (!preg_match("/^[ A-Z\.\-]{3,}$/", $field))
        {
            return ["Can contain letters, hyphen and dot"];
        }
        return $field;
    }
}