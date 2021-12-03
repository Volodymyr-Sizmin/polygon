<?php

namespace App\Service\Playlist;

use App\Entity\Playlist;
use App\Interfaces\Playlist\PlaylistServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class PlaylistService implements PlaylistServiceInterface
{

    private $enityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->enityManager = $em;
        $this->playlist     = $this->enityManager->getRepository(Playlist::class);
    }

    public function indexService(): array
    {
        return  $this->playlist->findAll();
    }

    /** Create Playlist
     *
     * @param array $data
     * @return Playlist
     */
    public function createPlaylist(array $data): Playlist
    {
        $playlist = new Playlist();

        $playlist->setName(isset($data["name"]) ? $data["name"] : $playlist->getName());
        $playlist->setDescription(isset($data["description"]) ? $data["description"] : $playlist->getDescription());
        $playlist->setCreatedAt(new \DateTimeImmutable());
        $playlist->setUpdatedAt(new \DateTimeImmutable());

        $this->enityManager->persist($playlist);
        $this->enityManager->flush();

        return $playlist;
    }
    
}