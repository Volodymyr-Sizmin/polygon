<?php

namespace App\Interfaces\MyTracklist;


interface MyTracklistInterface 
{
    public function indexService();

    public function createService();

    public function storeService();

    public function showService();

    public function editService();

    public function updateService();

    public function destroyService();
}
