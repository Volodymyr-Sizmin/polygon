<?php

namespace App\Entity;

use App\Repository\UtilitiesProviderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilitiesProviderRepository::class)
 */
class UtilitiesProvider
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $utility;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

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

    public function getUtility(): ?string
    {
        return $this->utility;
    }

    public function setUtility(string $utility): self
    {
        $this->utility = $utility;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }
}
