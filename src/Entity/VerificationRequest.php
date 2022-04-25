<?php

namespace App\Entity;

use App\Repository\VerificationRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VerificationRequestRepository::class)
 */
class VerificationRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiresAt;

    /**
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    private $verified;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups = {"email"}, message = "Invalid e-mail Address")
     * @Assert\Regex(
     *      groups = {"email"}, 
     *      pattern = "/^[a-zа-я0-9!#$%&`*\-=+'?{}\|~]+\.{0,1}[a-zа-я0-9!#$%&`*\-=+'?{}\|~]+@[a-zа-я0-9!#$%&`*\-=+'?{}\|~.]+[a-zа-я0-9!#$%&`*\-=+'?{}\|~]+$/iu", 
     *      message = "Invalid e-mail Address"
     * )     
     */
    private $email;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    public function __construct($dest)
    {
        $urlstr = date('Ymd').bin2hex(random_bytes(20));
        $this->url = md5($urlstr);
        $this->verified = false;
        $this->expiresAt = new \DateTime('+1 day');
        $this->email = $dest;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function checkExpired(): bool
    {
        $now = new \DateTime('now');
        return $this->expiresAt < $now;
    }

    public function getExpiresAt(): ?\DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTime $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getVerified(): ?bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): self
    {
        $this->verified = $verified;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
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

}
