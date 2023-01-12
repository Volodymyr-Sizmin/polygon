<?php

namespace App\Entity;

use App\Repository\PaymentStatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="payment_statuses")
 * @ORM\Entity(repositoryClass=PaymentStatusRepository::class)
 */
class PaymentStatus
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
    private $name_id;

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

    public function getNameId(): ?string
    {
        return $this->name_id;
    }

    public function setNameId(string $name_id): self
    {
        $this->name_id = $name_id;

        return $this;
    }
}
