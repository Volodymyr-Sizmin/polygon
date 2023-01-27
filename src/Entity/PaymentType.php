<?php

namespace App\Entity;

use App\Repository\PaymentTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="payment_types")
 * @ORM\Entity(repositoryClass=PaymentTypeRepository::class)
 */
class PaymentType
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
     * @ORM\Column(type="integer")
     */
    private $on_the_main_page;

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

    public function getOnTheMainPage(): ?int
    {
        return $this->on_the_main_page;
    }

    public function setOnTheMainPage(int $on_the_main_page): self
    {
        $this->on_the_main_page = $on_the_main_page;

        return $this;
    }
}
