<?php

namespace App\Interfaces\MyTracklist;

use App\DTO\TracklistDTO;
use App\Entity\Track;

interface MyTracklistInterface 
{
    /**
     * @return object
     */
    public function indexService();

    /**
     *@return array 
     */
    public function createService();

    /**
     * @param object $tracklistDTO DTO for Request.
     * 
     * @return object
     */
    public function storeService(TracklistDTO $tracklistDTO);

    /**
     * @param Int $id The identifier
     * 
     * @return object|array 
     */
    public function showService($id);

    /**
     *@param Int $id The identifier.
     * 
     *@return object|array 
     */   
    public function editService($id);

    /**
     * @param object $tracklistDTO DTO for Request.
     * @param object $track Repository of Track.
     * 
     * @return object
     */
    public function updateService(TracklistDTO $tracklistDTO, Track $track);

    /**
     * @param Int $id The identifier.
     * 
     * @return array
     */
    public function deleteService($id);
}
