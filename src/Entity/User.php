<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email")
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
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Regex(
     *     pattern="/^[a-z]{3,25}|[1-9]{1,4}\@[a-z]{1,10}\.[a-z]{1,4}/", groups={"registration"},
     *     match=true, groups={"registration"},
     *     message="This email is not valid", groups={"registration"}
     * )
     * @Assert\Length(
     *      min = 10, groups={"registration"},
     *      max = 60, groups={"registration"},
     *      minMessage = "Your email symbol number must be at least 3 characters long", groups={"registration"},
     *      maxMessage = "Your email symbol number cannot be longer than 50 characters", groups={"registration"}
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"password"})
     * @Assert\Regex(
     *     pattern="/^\w{5,50}\d{1,50}/", groups={"password"},
     *     match=true, groups={"password"},
     *     message="Your password must contain letters and numbers", groups={"password"}
     * )
     * @Assert\Length(
     *      min = 6, groups={"password"},
     *      max = 50, groups={"password"},
     *      minMessage = "Your password must be at least 6 characters long", groups={"password"},
     *      maxMessage = "Your password cannot be longer than 50 characters", groups={"password"}
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"code"})
     * @Assert\Regex(
     *     pattern="/[0-9]{6}/", groups={"code"},
     *     match=true, groups={"code"},
     *     message="Your password must contain only numbers and be 6 numbers long", groups={"code"}
     * )
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     * * @Assert\NotBlank(groups={"token"})
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"quest"})
     * @Assert\Regex(
     *     pattern="/\w{1,40}|d{1,10}|\s|\?|\!/", groups={"quest"},
     *     match=true, groups={"quest"},
     *     message="Your question is invalid", groups={"quest"}
     * )
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"quest"})
     * @Assert\Regex(
     *     pattern="/\w{1,40}|d{1,10}|\s|\?|\!/", groups={"quest"},
     *     match=true, groups={"quest"},
     *     message="Your answer is invalid", groups={"quest"}
     * )
     */
    private $answer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"passport"})
     * @Assert\Regex(
     *     pattern="/[a-zA-Z]{2,26}|\s|[0-9]{1,33}/", groups={"passport"},
     *     match=true, groups={"passport"},
     *     message="Your id is invalid", groups={"passport"}
     * )
     * @Assert\Length(
     *      min = 5, groups={"passport"},
     *      max = 50, groups={"passport"},
     *      minMessage = "Your id must be at least 5 characters long", groups={"passport"},
     *      maxMessage = "Your id cannot be longer than 50 characters", groups={"passport"}
     * )
     */
    private $passport_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"name"})
     * @Assert\Regex(
     *     pattern="/[A-Za-z]{1,33}|\'|\-|\s/", groups={"name"},
     *     match=true, groups={"name"},
     *     message="Your name is invalid", groups={"name"}
     * )
     */
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"name"})
     * @Assert\Regex(
     *     pattern="/[A-Za-z]{1,33}|\'|\-|\s/", groups={"name"},
     *     match=true, groups={"name"},
     *     message="Your name is invalid", groups={"name"}
     * )
     */
    private $LastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reset_code;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(groups={"pin"})
     * @Assert\Regex(
     *     pattern="/^\d{6}$/", groups={"pin"},
     *     match=true, groups={"pin"},
     *     message="Your pin is invalid", groups={"pin"}
     * )
     *  * @Assert\Length(
     *      min = 6, groups={"pin"},
     *      max = 6, groups={"pin"},
     *      minMessage = "Your pin must be at least 6 characters long", groups={"pin"},
     *      maxMessage = "Your pin cannot be longer than 6 characters", groups={"pin"}
     * )
     */
    private $pin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reset_pin;

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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken($token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getPassportId(): ?string
    {
        return $this->passport_id;
    }

    public function setPassportId(?string $passport_id): self
    {
        $this->passport_id = $passport_id;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(?string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(?string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getResetCode(): ?string
    {
        return $this->reset_code;
    }

    public function setResetCode(?string $reset_code): self
    {
        $this->reset_code = $reset_code;

        return $this;
    }

    public function getPin(): ?int
    {
        return $this->pin;
    }

    public function setPin(?int $pin): self
    {
        $this->pin = $pin;

        return $this;
    }

    public function getResetPin(): ?int
    {
        return $this->reset_pin;
    }

    public function setResetPin(?int $reset_pin): self
    {
        $this->reset_pin = $reset_pin;

        return $this;
    }
}
