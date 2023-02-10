<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 */
class Card
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $card_type_name;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=29)
     */
    private $account_number;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $currency_name;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $transaction_limit;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $credit_limit;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $pin_code;

    /**
     * @ORM\Column(type="integer")
     */
    private $answer_attempts;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiry_date;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCardTypeName(): ?string
    {
        return $this->card_type_name;
    }

    public function setCardTypeName(string $card_type_name): self
    {
        $this->card_type_name = $card_type_name;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->account_number;
    }

    public function setAccountNumber(string $account_number): self
    {
        $this->account_number = $account_number;

        return $this;
    }

    public function getCurrencyName(): ?string
    {
        return $this->currency_name;
    }

    public function setCurrencyName(string $currency_name): self
    {
        $this->currency_name = $currency_name;

        return $this;
    }

    public function getTransactionLimit(): ?string
    {
        return $this->transaction_limit;
    }

    public function setTransactionLimit(?string $transaction_limit): self
    {
        $this->transaction_limit = $transaction_limit;

        return $this;
    }

    public function getCreditLimit(): ?string
    {
        return $this->credit_limit;
    }

    public function setCreditLimit(?string $credit_limit): self
    {
        $this->credit_limit = $credit_limit;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPinCode(): ?int
    {
        return $this->pin_code;
    }

    public function setPinCode(int $pin_code): self
    {
        $this->pin_code = $pin_code;

        return $this;
    }

    public function getAnswerAttempts(): ?int
    {
        return $this->answer_attempts;
    }

    public function setAnswerAttempts(int $answer_attempts): self
    {
        $this->answer_attempts = $answer_attempts;

        return $this;
    }

    public function getExpiryDate(): ?\DateTimeInterface
    {
        return $this->expiry_date;
    }

    public function setExpiryDate(\DateTimeInterface $expiry_date): self
    {
        $this->expiry_date = $expiry_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
