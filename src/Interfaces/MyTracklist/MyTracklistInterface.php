<?php

namespace App\Interfaces\MyTracklist;

use App\DTO\TracklistDTO;
use App\Entity\Track;

interface MyTracklistInterface
{
    /**
     * @return array
     */
    public function indexService(): array;

    /**
     * @return array
     */
    public function createService(): array;

    /**
     * the method in the service is a stub before creating the admin panel and the corresponding tables
     * when everything is ready, you can change this method
     * @param TracklistDTO $tracklistDTO
     * @return Track
     */
    public function storeService(TracklistDTO $tracklistDTO): Track;

    /**
     * @param int $id
     * @return object
     */
    public function showService(int $id): object;

    /**
     * @param int $id
     * @return object
     */
    public function editService(int $id): object;

    /**
     * @param TracklistDTO $tracklistDTO
     * @param int $id
     * @return Track
     */
    public function updateService(TracklistDTO $tracklistDTO, int $id): Track;

    /**
     * @param int $id
     * @return array
     */
    public function deleteService(int $id): array;
}
