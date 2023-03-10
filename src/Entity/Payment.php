<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="payments")
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $account_debit_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $account_credit_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="integer")
     */
    private $currency_id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $status_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $type_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $card_debit_number;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $card_credit_number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getAccountDebitId(): ?string
    {
        return $this->account_debit_id;
    }

    public function setAccountDebitId(string $account_debit_id): self
    {
        $this->account_debit_id = $account_debit_id;

        return $this;
    }

    public function getAccountCreditId(): ?string
    {
        return $this->account_credit_id;
    }

    public function setAccountCreditId(string $account_credit_id): self
    {
        $this->account_credit_id = $account_credit_id;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrencyId(): ?int
    {
        return $this->currency_id;
    }

    public function setCurrencyId(int $currency_id): self
    {
        $this->currency_id = $currency_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatusId(): ?int
    {
        return $this->status_id;
    }

    public function setStatusId(int $status_id): self
    {
        $this->status_id = $status_id;

        return $this;
    }

    public function getTypeId(): ?int
    {
        return $this->type_id;
    }

    public function setTypeId(int $type_id): self
    {
        $this->type_id = $type_id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCardDebitNumber(): ?string
    {
        return $this->card_debit_number;
    }

    public function setCardDebitNumber(string $card_debit_number): self
    {
        $this->card_debit_number = $card_debit_number;

        return $this;
    }

    public function getCardCreditNumber(): ?string
    {
        return $this->card_credit_number;
    }

    public function setCardCreditNumber(string $card_credit_number): self
    {
        $this->card_credit_number = $card_credit_number;

        return $this;
    }
}
