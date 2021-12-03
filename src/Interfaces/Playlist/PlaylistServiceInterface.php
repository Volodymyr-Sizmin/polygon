<?php

namespace App\Interfaces\Playlist;

use App\Entity\Playlist;

interface PlaylistServiceInterface{

    public function indexService():array;

    public function createPlaylist(array $data):Playlist;
    
}