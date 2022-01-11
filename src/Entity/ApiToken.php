<?php

namespace App\Entity;

use App\Repository\ApiTokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApiTokenRepository::class)
 */
class ApiToken
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
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiresAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="apiTokens")
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    private $remember;

    public function __construct(User $user, $remember = false)
    {
        $this->token = bin2hex(random_bytes(60));
        $this->user = $user;
        $this->remember = $remember;
        $this->renewExpiresAt();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function renewExpiresAt()
    {
        $this->expiresAt = new \DateTime('+1 hour');
    }

    public function checkExpired()
    {
        if ($this->expiresAt instanceof \DateTime) {
            $now = new \DateTime('now');
            return $this->expiresAt < $now;
        }
            return $this->expiresAt;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRemember(): ?bool
    {
        return $this->remember;
    }

    public function setRemember(bool $remember): self
    {
        $this->remember = $remember;

        return $this;
    }
}
