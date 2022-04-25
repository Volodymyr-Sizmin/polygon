<?php

namespace App\Interfaces\MyTracklist;

use App\DTO\TracklistDTO;
use App\Entity\Track;

interface MyTracklistInterface
{
    public function indexService(): array;

    public function createService(): array;

    /**
     * the method in the service is a stub before creating the admin panel and the corresponding tables
     * when everything is ready, you can change this method.
     */
    public function storeService(TracklistDTO $tracklistDTO): Track;

    public function showService(int $id): object;

    public function editService(int $id): object;

    public function updateService(TracklistDTO $tracklistDTO, int $id): Track;

    public function deleteService(int $id): array;
}
