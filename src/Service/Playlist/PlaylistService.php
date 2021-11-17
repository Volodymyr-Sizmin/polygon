<?php

namespace App\Service\Playlist;

use App\Entity\Playlist;
use App\Interfaces\Playlist\PlaylistInterface;
use Doctrine\ORM\EntityManagerInterface;

class PlaylistService implements PlaylistInterface
{

    private $enityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->enityManager = $em;
        $this->playlist     = $this->enityManager->getRepository(Playlist::class);
    }

    public function indexService()
    {
        return  $this->playlist->findAll();
    }
    
}