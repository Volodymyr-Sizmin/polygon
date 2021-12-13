<?php

namespace App\Service\MyTracklist;

use App\Interfaces\MyTracklist\MyTracklistInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Track;
use App\Service\FileUploader;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Filesystem\Filesystem;

class MyTracklistService implements MyTracklistInterface
{
    private $entityManager;
    private $trackRepository;
    private $fileUploader;

    public function __construct(EntityManagerInterface $entityManagerInterface, FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
        $this->entityManager = $entityManagerInterface;
        $this->trackRepository = $this->entityManager->getRepository(Track::class);
    }

    public function indexService()
    {
        return $this->trackRepository->findAll();
    }

    public function createService(): array
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
        $track = new Track();

        if ($tracklistDTO->album !== null) {
            $track->setAlbum($tracklistDTO->album);
        }

        if ($tracklistDTO->cover !== null) {
            $track->setCover($this->fileUploader->upload($tracklistDTO->cover)->getUrl());
        }

        if ($tracklistDTO->track_path !== null) {
            $track->setTrackPath($this->fileUploader->upload($tracklistDTO->track_path)->getUrl());
        }

        if ($tracklistDTO->title !== null) {
            $track->setTitle($tracklistDTO->title);
        }

        if ($tracklistDTO->author !== null) {
            $track->setAuthor($tracklistDTO->author);
        }

        if ($tracklistDTO->type !== null) {
            $track->setType($tracklistDTO->type);
        }

        if ($tracklistDTO->genre !== null) {
            $track->setGenre($tracklistDTO->genre);
        }

        $this->entityManager->persist($track);
        $this->entityManager->flush();

        return $track;
    }

    public function showService($id)
    {
        if ($this->trackRepository->find($id) == null) {
            return array([
                'success' => false,
                'body'    => 'Can not find track'
            ]);
        }
        return $this->trackRepository->find($id);
    }

    public function editService($id)
    {
        if ($this->trackRepository->find($id) == null) {
            return array([
                'success' => false,
                'body'    => 'Track not found'
            ]);
        }
        return $this->trackRepository->find($id);
    }

    public function updateService($tracklistDTO, $track)
    {
        $fileSystem = new Filesystem();

        if ($tracklistDTO->cover !== null) {
            $fileSystem->remove('../public/uploads/' . $track->getCover());
            $track->setCover($this->fileUploader->upload($tracklistDTO->cover)->getUrl());
        }

        if ($tracklistDTO->album !== null) {
            $track->setAlbum($tracklistDTO->album);
        }

        if ($tracklistDTO->title !== null) {
            $track->setTitle($tracklistDTO->title);
        }

        if ($tracklistDTO->author !== null) {
            $track->setAuthor($tracklistDTO->author);
        }

        if ($tracklistDTO->type !== null) {
            $track->setType($tracklistDTO->type);
        }

        if ($tracklistDTO->genre !== null) {
            $track->setGenre($tracklistDTO->genre);
        }

        $this->entityManager->flush();

        return $track;
    }

    public function deleteService($id)
    {
        if ($this->trackRepository->find($id) == null) {
            return array([
                'success' => false,
                'body'    => 'Track not found'
            ]);
        }

        $this->entityManager->remove($this->trackRepository->find($id));
        $this->entityManager->flush();

        return array([
            'success' => true,
            'body'    => 'Track was successfully deleted'
        ]);
    }
}
