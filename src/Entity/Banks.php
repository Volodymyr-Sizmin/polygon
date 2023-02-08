<?php

namespace App\Entity;

use App\Repository\BanksRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BanksRepository::class)
 */
class Banks
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_country;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $short_name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $IBAN;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $SWIFT;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCountry(): ?int
    {
        return $this->id_country;
    }

    public function setIdCountry(int $id_country): self
    {
        $this->id_country = $id_country;

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

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(string $short_name): self
    {
        $this->short_name = $short_name;

        return $this;
    }

    public function getIBAN(): ?string
    {
        return $this->IBAN;
    }

    public function setIBAN(string $IBAN): self
    {
        $this->IBAN = $IBAN;

        return $this;
    }

    public function getSWIFT(): ?string
    {
        return $this->SWIFT;
    }

    public function setSWIFT(string $SWIFT): self
    {
        $this->SWIFT = $SWIFT;

        return $this;
    }
}
