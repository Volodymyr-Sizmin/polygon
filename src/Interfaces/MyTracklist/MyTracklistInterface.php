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
     * @param $id
     * @return object
     */
    public function showService($id): object;

    /**
     * @param $id
     * @return object
     */
    public function editService($id): object;

    /**
     * @param TracklistDTO $tracklistDTO
     * @param Track $track
     * @return Track
     */
    public function updateService(TracklistDTO $tracklistDTO, Track $track): Track;

    /**
     * @param $id
     * @return array
     */
    public function deleteService($id): array;
}
