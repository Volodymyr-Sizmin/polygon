<?php
namespace App\Service\MyTraclist;

use App\Interfaces\MyTracklist\MyTracklistInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Track;
use App\Service\FileUploader;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Filesystem\Filesystem;

class MyTraclistService implements MyTracklistInterface
{
    private $entityManager;
    private $trackRepository;
    private $fileUploader;

    public function __construct(EntityManagerInterface $entityManagerInterface, FileUploader $fileUploader)
    {
        $this->fileUploader =$fileUploader;
        $this->entityManager = $entityManagerInterface;
        $this->trackRepository = $this->entityManager->getRepository(Track::class);
    }
    public function indexService()
    {
        return $this->trackRepository->findAll();
    }

    public function createService():array
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

    public function storeService($tracklistDTO)
    {
        $track = new Track;

        if($tracklistDTO->album !== NULL)
        {
            $track->setAlbum($tracklistDTO->album);
        }
        if($tracklistDTO->cover !== NULL)
        {
            $track->setCover($this->fileUploader->upload($tracklistDTO->cover)->getUrl());
        }

        $track->setTrackPath($this->fileUploader->upload($tracklistDTO->track_path)->getUrl());
 
        $track->setTitle($tracklistDTO->title);
        $track->setAuthor($tracklistDTO->author);
        $track->setType($tracklistDTO->type);
        $track->setGenre($tracklistDTO->genre);

        $this->entityManager->persist($track);
        $this->entityManager->flush();

        return $track;
    }

    public function showService($id)
    {   

        if ($this->trackRepository->find($id) == NULL ) 
        {
                        return array([
                'success' => false,
                'body'    => 'Can not find track'
            ]); 
        }
        return $this->trackRepository->find($id);

    }

    public function editService($id)
    {

        if ($this->trackRepository->find($id) == NULL ) 
        {
                        return array([
                'success' => false,
                'body'    => 'Can not find track'
            ]); 
        }
        return $this->trackRepository->find($id);

    }

    public function updateService($tracklistDTO, $track)
    {
        $fileSystem = new Filesystem;

        if($tracklistDTO->cover !== NULL)
        {
            $fileSystem->remove('../public/uploads/'.$track->getCover());
            $track->setCover($this->fileUploader->upload($tracklistDTO->cover)->getUrl());
        }

        if($tracklistDTO->album !== NULL)
        {
            $track->setAlbum($tracklistDTO->album);
        }

        if($tracklistDTO->title !== NULL)
        {
            $track->setTitle($tracklistDTO->title);
        }

        if ($tracklistDTO->author !== NULL) 
        {
            $track->setAuthor($tracklistDTO->author);
        }

        if ($tracklistDTO->type !== NULL) 
        {
            $track->setType($tracklistDTO->type);
        }

        if ($tracklistDTO->genre !== NULL) 
        {
            $track->setGenre($tracklistDTO->genre);
        }
        
        $this->entityManager->flush();
      
        return $track;
    }

    public function deleteService($id)
    {
        if ($this->trackRepository->find($id) == NULL ) 
        {
            return array([
                'success' => false,
                'body'    => 'Can not find track'
            ]);
        }
        
        $this->entityManager->remove($this->trackRepository->find($id));
        $this->entityManager->flush();

        return array([
            'success' => true, 
            'body'    => 'Track successfully deleted'
        ]);
    }
}