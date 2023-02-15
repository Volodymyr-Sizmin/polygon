<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CardDTO
{
    public string $id;

    public int $balance;

    public string $user_id;

    public string $name;

    public string $card_type_name;

    public string $number;

    public string $account_number;

    public string $currency_name;

    public string $transaction_limit;

    public string $credit_limit;

    public string $status;

    public string $pin_code;

    public int $answer_attempts;

    public string $expiry_date;

    public string $created_at;

    public string $updated_at;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @param int $balance
     */
    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCardTypeName(): string
    {
        return $this->card_type_name;
    }

    /**
     * @param string $card_type_name
     */
    public function setCardTypeName(string $card_type_name): void
    {
        $this->card_type_name = $card_type_name;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string
    {
        return $this->account_number;
    }

    /**
     * @param string $account_number
     */
    public function setAccountNumber(string $account_number): void
    {
        $this->account_number = $account_number;
    }

    /**
     * @return string
     */
    public function getCurrencyName(): string
    {
        return $this->currency_name;
    }

    /**
     * @param string $currency_name
     */
    public function setCurrencyName(string $currency_name): void
    {
        $this->currency_name = $currency_name;
    }

    /**
     * @return string
     */
    public function getTransactionLimit(): string
    {
        return $this->transaction_limit;
    }

    /**
     * @param string $transaction_limit
     */
    public function setTransactionLimit(string $transaction_limit): void
    {
        $this->transaction_limit = $transaction_limit;
    }

    /**
     * @return string
     */
    public function getCreditLimit(): string
    {
        return $this->credit_limit;
    }

    /**
     * @param string $credit_limit
     */
    public function setCreditLimit(string $credit_limit): void
    {
        $this->credit_limit = $credit_limit;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getPinCode(): int
    {
        return $this->pin_code;
    }

    /**
     * @param int $pin_code
     */
    public function setPinCode(int $pin_code): void
    {
        $this->pin_code = $pin_code;
    }

    /**
     * @return int
     */
    public function getAnswerAttempts(): int
    {
        return $this->answer_attempts;
    }

    /**
     * @param int $answer_attempts
     */
    public function setAnswerAttempts(int $answer_attempts): void
    {
        $this->answer_attempts = $answer_attempts;
    }

    /**
     * @return string
     */
    public function getExpiryDate(): string
    {
        return $this->expiry_date;
    }

    /**
     * @param string $expiry_date
     */
    public function setExpiryDate(string $expiry_date): void
    {
        $this->expiry_date = $expiry_date;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }


}
