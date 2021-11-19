<?php
namespace App\Service\MyTraclist;

use App\Interfaces\MyTracklist\MyTracklistInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Track;

class MyTraclistService implements MyTracklistInterface
{
    private $entityManager;
    private $trackRepository;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManager = $entityManagerInterface;
        $this->trackRepository = $this->entityManager->getRepository(Track::class);
    }
    public function indexService()
    {
        return $this->trackRepository->findAll();
    }

    public function createService()
    {
        return array([
            'trackType' => ['Book', 'Podcast', 'Music'],
            'genreType' => [
                'Rock',
                'Pop', 
                'Classical', 
                'Jazz', 
                'Blues', 
                'Hip-Hop', 
                'Hardcore', 
                'Metal', 
                'Trance', 
                'House', 
                'Punk', 
                'Grunge', 
                'Folk',
                "Drum'n'bass",
                'Russian Chanson', 
                'Retro', 
                'Funk', 
                'Ethnic', 
                'Reggae', 
                'Lounge'
            ]
        ]);
    }

    public function storeService()
    {
        
    }

    public function showService()
    {

    }

    public function editService()
    {

    }

    public function updateService()
    {

    }

    public function destroyService()
    {
        
    }
}