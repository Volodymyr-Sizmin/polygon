<?php

namespace App\DTO;

class PaymentServiceDTO
{
    private string $userId;
    private string $subject;
    private string $accountDebitId;
    private string $accountCreditId;
    private float $amount;
    private int $currencyId;
    private int $statusId;
    private int $typeId;
    private string $name;
    private string $cardDebitNumber;
    private string $cardCreditNumber;

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getAccountDebitId(): string
    {
        return $this->accountDebitId;
    }

    /**
     * @param string $accountDebitId
     */
    public function setAccountDebitId(string $accountDebitId): void
    {
        $this->accountDebitId = $accountDebitId;
    }

    /**
     * @return string
     */
    public function getAccountCreditId(): string
    {
        return $this->accountCreditId;
    }

    /**
     * @param string $accountCreditId
     */
    public function setAccountCreditId(string $accountCreditId): void
    {
        $this->accountCreditId = $accountCreditId;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    /**
     * @param int $currencyId
     */
    public function setCurrencyId(int $currencyId): void
    {
        $this->currencyId = $currencyId;
    }

    /**
     * @return int
     */
    public function getStatusId(): int
    {
        return $this->statusId;
    }

    /**
     * @param int $statusId
     */
    public function setStatusId(int $statusId): void
    {
        $this->statusId = $statusId;
    }

    /**
     * @return int
     */
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * @param int $typeId
     */
    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
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
    public function getCardDebitNumber(): string
    {
        return $this->cardDebitNumber;
    }

    /**
     * @param string $cardDebitNumber
     */
    public function setCardDebitNumber(string $cardDebitNumber): void
    {
        $this->cardDebitNumber = $cardDebitNumber;
    }

    /**
     * @return string
     */
    public function getCardCreditNumber(): string
    {
        return $this->cardCreditNumber;
    }

    /**
     * @param string $cardCreditNumber
     */
    public function setCardCreditNumber(string $cardCreditNumber): void
    {
        $this->cardCreditNumber = $cardCreditNumber;
    }


}