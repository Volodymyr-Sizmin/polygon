<?php

namespace App\Entity;

use App\Repository\CardTypesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardTypesRepository::class)
 */
class CardTypes
{
    const CURRENCY = ['GBP' => ['GBP'], 'multi' => ['GBP', 'USD','EUR']];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $free_service_from_turnover;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $transfer_fees;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $withdrawal_terms;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cashback_terms;

    /**
     * @ORM\Column(type="string")
     */
    private $card_validity_years;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $interest_percent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $other_advantages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currency;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFreeServiceFromTurnover(): ?int
    {
        return $this->free_service_from_turnover;
    }

    public function setFreeServiceFromTurnover(?int $free_service_from_turnover): self
    {
        $this->free_service_from_turnover = $free_service_from_turnover;

        return $this;
    }

    public function getTransferFees()
    {
        return $this->transfer_fees;
    }

    public function setTransferFees($transfer_fees): self
    {
        $this->transfer_fees = $transfer_fees;

        return $this;
    }

    public function getWithdrawalTerms(): ?string
    {
        return $this->withdrawal_terms;
    }

    public function setWithdrawalTerms(?string $withdrawal_terms): self
    {
        $this->withdrawal_terms = $withdrawal_terms;

        return $this;
    }

    public function getCashbackTerms(): ?string
    {
        return $this->cashback_terms;
    }

    public function setCashbackTerms(?string $cashback_terms): self
    {
        $this->cashback_terms = $cashback_terms;

        return $this;
    }

    public function getCardValidityYears(): ?int
    {
        return $this->card_validity_years;
    }

    public function setCardValidityYears(int $card_validity_years): self
    {
        $this->card_validity_years = $card_validity_years;

        return $this;
    }

    public function getInterestPercent(): ?float
    {
        return $this->interest_percent;
    }

    public function setInterestPercent(?float $interest_percent): self
    {
        $this->interest_percent = $interest_percent;

        return $this;
    }

    public function getOtherAdvantages(): ?string
    {
        return $this->other_advantages;
    }

    public function setOtherAdvantages(?string $other_advantages): self
    {
        $this->other_advantages = $other_advantages;

        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency(array  $currency)
    {
        $this->currency = $currency;

        return $this;
    }
}
