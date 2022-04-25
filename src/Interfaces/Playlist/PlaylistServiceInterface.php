<?php

namespace App\Interfaces\Playlist;

interface PlaylistServiceInterface
{
    public function indexService(): array;

    public function createPlaylist(array $data);
}
