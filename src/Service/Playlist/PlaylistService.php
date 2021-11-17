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
    
}