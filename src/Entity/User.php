<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email")
 * @UniqueEntity("phone")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true)
     * @Assert\NotBlank(groups = {"email"}, message = "Invalid e-mail Address")
     * @Assert\Regex(
     *      groups = {"email"}, 
     *      pattern = "/^[a-zа-я0-9!#$%&`*\-=+'?{}\|~]+\.{0,1}[a-zа-я0-9!#$%&`*\-=+'?{}\|~]+@[a-zа-я0-9!#$%&`*\-=+'?{}\|~.]+[a-zа-я0-9!#$%&`*\-=+'?{}\|~]+$/iu", 
     *      message = "Invalid e-mail Address"
     * )     
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     * @Assert\Sequentially({
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Must be {{ limit }} characters or more",
     *      maxMessage = "Must be {{ limit }} characters or less"
     * ),
     * @Assert\Regex(
     *      pattern = "/^[a-zа-я0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~ ]+\.{0,1}[a-zа-я0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~ ]+$/iu", 
     *      message = "Can contain letters, numbers, !@#$%^&*()_-=+;:'""?,<>[]{}\|/№!~' symbols, and one dot not first or last"
     * )
     * })
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     * @Assert\Sequentially({
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Must be {{ limit }} characters or more",
     *      maxMessage = "Must be {{ limit }} characters or less"
     * ),
     * @Assert\Regex(
     *      pattern = "/^[a-zа-я0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~ ]+\.{0,1}[a-zа-я0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~ ]+$/iu", 
     *      message = "Can contain letters, numbers, !@#$%^&*()_-=+;:'""?,<>[]{}\|/№!~' symbols, and one dot not first or last"
     * )
     * })
     */
    private $lastName;

    /**
     * @ORM\Column(type="string")
     * @Assert\Sequentially({
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Must be {{ limit }} characters or more",
     *      maxMessage = "Must be {{ limit }} characters or less"
     * ),
     * @Assert\Regex(
     *      pattern = "/^[a-zа-я0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~ ]+\.{0,1}[a-zа-я0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~ ]+$/iu", 
     *      message = "Can contain letters, numbers, !@#$%^&*()_-=+;:'""?,<>[]{}\|/№!~' symbols, and one dot not first or last"
     * )
     * })
     */
    private $userName;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true)
     * @Assert\Sequentially({
     * @Assert\Length(
     *      groups = {"phone"},
     *      min = 7,
     *      max = 13,
     *      minMessage = "Must be {{ limit }} characters or more",
     *      maxMessage = "Must be {{ limit }} characters or less"
     * ),
     * @Assert\Regex(
     *      groups = {"phone"}, 
     *      pattern = "/^\+[0-9]{6,12}$/", 
     *      message = "incorrect phone format"
     * )
     * })
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity=ApiToken::class, mappedBy="user")
     */
    private $apiTokens;

    /**
     * @ORM\Column(type="boolean", name="is_deleted")
     */
    private $isDeleted;

    public function __construct()
    {
        $this->apiTokens = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function setDefaults(): void
    {
        $this->isDeleted = false;
    }

    public function getPublicData(): array
    {
        return [
            "id" => $this->getId(),
            "username" => $this->getUsername()
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    private function removeSpaces(string $str) :string
    {
        $str = preg_replace('/\s\s+/', ' ', $str);
        $str = preg_replace('/^ /', '', $str);
        $str = preg_replace('/ $/', '', $str);
        return $str;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $this->removeSpaces($firstName);

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $this->removeSpaces($lastName);

        return $this;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $this->removeSpaces($userName);

        return $this;
    }

    public function getUsername(): string
    {
        return $this->userName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|ApiToken[]
     */
    public function getApiTokens(): Collection
    {
        return $this->apiTokens;
    }

    public function addApiToken(ApiToken $apiToken): self
    {
        if (!$this->apiTokens->contains($apiToken)) {
            $this->apiTokens[] = $apiToken;
            $apiToken->setUser($this);
        }

        return $this;
    }

    public function removeApiToken(ApiToken $apiToken): self
    {
        $this->apiTokens->removeElement($apiToken);
        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
}
