<?php
namespace App\Service\MyTraclist;

use App\Interfaces\MyTracklist\MyTracklistInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Track;
use App\Service\FileUploader;

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
            $track->setCover($this->fileUploader->getTargetDirectory()."/". $this->fileUploader->upload($tracklistDTO->cover));
        }

        //here we take target directory and make upload file which return string of file URL 
        $track->setTrackPath($this->fileUploader->getTargetDirectory()."/". $this->fileUploader->upload($tracklistDTO->track_path));
 
        $track->setTitle($tracklistDTO->title);
        $track->setAuthor($tracklistDTO->author);
        $track->setType($tracklistDTO->type);
        $track->setGenre($tracklistDTO->genre);

        $track->setCreatedAt(new \DateTimeImmutable());
        $track->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($track);
        $this->entityManager->flush();

        return $track;
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

    public function deleteService($id)
    {
        $this->entityManager->remove($this->trackRepository->find($id));
        $this->entityManager->flush();

        return array([
            'success' => true, 
            'body'    => 'Track successfully deleted'
        ]);
    }
}