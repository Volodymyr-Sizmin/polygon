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
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $account_id;

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

    public function getAccount(): ?int
    {
        return $this->account_id;
    }

    public function setAccount(?int $account_id): self
    {
        $this->account_id = $account_id;

        return $this;
    }
}
