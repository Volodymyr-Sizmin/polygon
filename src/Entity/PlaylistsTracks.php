<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlaylistsTracksRepository;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=PlaylistsTracksRepository::class)
 */
class PlaylistsTracks
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="playlist_id")
     */
    private $playlist_id;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="track_id")
     */
    private $track_id;

    /**
     * @return mixed
     */
    public function getPlaylistId()
    {
        return $this->playlist_id;
    }

    /**
     * @param mixed $playlist_id
     */
    public function setPlaylistId($playlist_id): void
    {
        $this->playlist_id = $playlist_id;
    }

    /**
     * @return mixed
     */
    public function getTrackId()
    {
        return $this->track_id;
    }

    /**
     * @param mixed $track_id
     */
    public function setTrackId($track_id): void
    {
        $this->track_id = $track_id;
    }
}