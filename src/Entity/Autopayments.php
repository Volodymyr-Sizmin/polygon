<?php

namespace App\Entity;

use App\Repository\AutopaymentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AutopaymentsRepository::class)
 */
class Autopayments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $user_email;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $name_of_payment;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $payment_category;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $cell_phone_operators;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $customer_number;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $card;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $payments_period;

    /**
     * @ORM\Column(type="boolean")
     */
    private $auto_charge_off;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(string $user_email): self
    {
        $this->user_email = $user_email;

        return $this;
    }

    public function getNameOfPayment(): ?string
    {
        return $this->name_of_payment;
    }

    public function setNameOfPayment(string $name_of_payment): self
    {
        $this->name_of_payment = $name_of_payment;

        return $this;
    }

    public function getPaymentCategory(): ?string
    {
        return $this->payment_category;
    }

    public function setPaymentCategory(string $payment_category): self
    {
        $this->payment_category = $payment_category;

        return $this;
    }

    public function getCellPhoneOperators(): ?string
    {
        return $this->cell_phone_operators;
    }

    public function setCellPhoneOperators(?string $cell_phone_operators): self
    {
        $this->cell_phone_operators = $cell_phone_operators;

        return $this;
    }

    public function getCustomerNumber(): ?string
    {
        return $this->customer_number;
    }

    public function setCustomerNumber(string $customer_number): self
    {
        $this->customer_number = $customer_number;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCard(): ?string
    {
        return $this->card;
    }

    public function setCard(string $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function getPaymentsPeriod(): ?string
    {
        return $this->payments_period;
    }

    public function setPaymentsPeriod(string $payments_period): self
    {
        $this->payments_period = $payments_period;

        return $this;
    }

    public function getAutoChargeOff(): ?bool
    {
        return $this->auto_charge_off;
    }

    public function setAutoChargeOff(bool $auto_charge_off): self
    {
        $this->auto_charge_off = $auto_charge_off;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
