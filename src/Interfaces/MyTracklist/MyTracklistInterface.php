<?php

namespace App\Interfaces\MyTracklist;

use App\DTO\TracklistDTO;
use App\Entity\Track;

interface MyTracklistInterface 
{
    public function indexService();

    public function createService():array;

    public function storeService(TracklistDTO $tracklistDTO);

    public function showService();

    public function editService();

    public function updateService();

    public function deleteService($id);
}
