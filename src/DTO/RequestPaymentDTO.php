<?php

namespace App\DTO;

class RequestPaymentDTO
{
    private $amount;

    private $cardNumber;

    private $cardNumberRecipient;

    private $account_debit;

    private $account_credit;

    private $subject;

    private $currency;

    private $headersAuth;

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param mixed $cardNumber
     */
    public function setCardNumber($cardNumber): void
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * @return mixed
     */
    public function getCardNumberRecipient()
    {
        return $this->cardNumberRecipient;
    }

    /**
     * @param mixed $cardNumberRecipient
     */
    public function setCardNumberRecipient($cardNumberRecipient): void
    {
        $this->cardNumberRecipient = $cardNumberRecipient;
    }

    /**
     * @return mixed
     */
    public function getAccountDebit()
    {
        return $this->account_debit;
    }

    /**
     * @param mixed $account_debit
     */
    public function setAccountDebit($account_debit): void
    {
        $this->account_debit = $account_debit;
    }

    /**
     * @return mixed
     */
    public function getAccountCredit()
    {
        return $this->account_credit;
    }

    /**
     * @param mixed $account_credit
     */
    public function setAccountCredit($account_credit): void
    {
        $this->account_credit = $account_credit;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getHeadersAuth()
    {
        return $this->headersAuth;
    }

    /**
     * @param mixed $headersAuth
     */
    public function setHeadersAuth($headersAuth): void
    {
        $this->headersAuth = $headersAuth;
    }


}
