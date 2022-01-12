<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlaylistRepository::class)
 */
class Playlist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Track", inversedBy="playlists")
     * @ORM\JoinTable(name="playlists_tracks")
     */

    /**
     * @ORM\Column(type="string", length=255)
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="playlist")
     * @ORM\Column(type="bigint")
     */
    private $cover;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Sequentially({
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Must be {{ limit }} characters or more",
     *      maxMessage = "Must be {{ limit }} characters or less"
     * ),
     * @Assert\Regex(
     *      pattern = "/^[a-zа-я0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~ ]+\.{0,1}[a-zа-я0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~ ]+$/iu",
     *      message = "Can contain letters, numbers, !@#$%^&*()_-=+;:'""?,<>[]{}\|/№!~' symbols, and one dot not first or last"
     * )
     * })
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="playlists")
     */
    private $author;

    /**
     * @ORM\Column(type="datetime_immutable", name="created_at")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", name="updated_at")
     */
    private $updatedAt;

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

    public function getCover(): ?File
    {
        return $this->cover;
    }

    public function setCover(?File $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $user): self
    {
        $this->author = $user;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
