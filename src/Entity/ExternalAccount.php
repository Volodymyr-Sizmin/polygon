<?php

namespace App\Entity;

use App\Repository\ExternalAccountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExternalAccountRepository::class)
 */
class ExternalAccount
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
    private $ext_user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $acc_number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtUserId(): ?int
    {
        return $this->ext_user_id;
    }

    public function setExtUserId(int $ext_user_id): self
    {
        $this->ext_user_id = $ext_user_id;

        return $this;
    }

    public function getAccNumber(): ?string
    {
        return $this->acc_number;
    }

    public function setAccNumber(string $acc_number): self
    {
        $this->acc_number = $acc_number;

        return $this;
    }
}
