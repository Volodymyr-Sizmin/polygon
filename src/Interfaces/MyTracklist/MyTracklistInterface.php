<?php

namespace App\Interfaces\MyTracklist;

use App\DTO\TracklistDTO;
use App\Entity\Track;

interface MyTracklistInterface 
{
    public function indexService();

    public function createService():array;

    public function storeService(TracklistDTO $tracklistDTO);

    public function showService($id);

    public function editService($id);

    public function updateService(TracklistDTO $tracklistDTO, Track $track);

    public function deleteService($id);
}
