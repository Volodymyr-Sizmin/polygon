<?php

namespace App\Service\MyTracklist;

use App\Interfaces\MyTracklist\MyTracklistInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Track;
use App\Interfaces\FileUploaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use App\Exception\MyTracklistException;

class MyTracklistService implements MyTracklistInterface
{
    private $entityManager;
    private $trackRepository;
    private $fileUploader;
    private $fileSystem;

    public function __construct(
        EntityManagerInterface $entityManagerInterface,
        FileUploaderInterface $fileUploader,
        Filesystem $fileSystem
    ) {
        $this->fileSystem = $fileSystem;
        $this->fileUploader = $fileUploader;
        $this->entityManager = $entityManagerInterface;
        $this->trackRepository = $this->entityManager->getRepository(Track::class);
    }

    /**
     * @return array
     */
    public function indexService(): array
    {
        return $this->trackRepository->findAll();
    }

    /**
     * @return array|mixed
     */
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

    /**
     * @param \App\DTO\TracklistDTO $tracklistDTO
     * @return Track
     * @throws \App\Exception\FileUploadException
     */
    public function storeService($tracklistDTO): Track
    {
        $track = new Track();

        if ($tracklistDTO->album !== null) {
            $track->setAlbum($tracklistDTO->album);
        }

        if ($tracklistDTO->cover !== null) {
            $track->setCover($this->fileUploader->upload($tracklistDTO->cover)->getPath());
        }

        if ($tracklistDTO->track_path !== null) {
            $track->setTrackPath($this->fileUploader->upload($tracklistDTO->track_path)->getPath());
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

    /**
     * @param int $id
     * @return object
     * @throws MyTracklistException
     */
    public function showService(int $id): object
    {
        if ($this->trackRepository->find($id) === null) {
            throw new MyTracklistException('Can not find track');
        }
        return $this->trackRepository->find($id);
    }

    /**
     * @param int $id
     * @return object
     * @throws MyTracklistException
     */
    public function editService(int $id): object
    {
        if ($this->trackRepository->find($id) === null) {
            throw new MyTracklistException('Can not find track');
        }
        return $this->trackRepository->find($id);
    }

    /**
     * @param \App\DTO\TracklistDTO $tracklistDTO
     * @param Track $track
     * @return Track
     * @throws \App\Exception\FileUploadException
     */
    public function updateService($tracklistDTO, $track): Track
    {
        if ($tracklistDTO->cover !== null) {
            $this->fileSystem->remove('../public/uploads/' . $track->getCover());
            $track->setCover($this->fileUploader->upload($tracklistDTO->cover)->getPath());
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

    /**
     * @param int $id
     * @return array
     * @throws MyTracklistException
     */
    public function deleteService(int $id): array
    {
        if ($this->trackRepository->find($id) === null) {
            throw new MyTracklistException('Can not find track');
        }

        if ($this->trackRepository->find($id)->getCover() !== null) {
            $this->fileSystem->remove('../public/uploads/' . $this->trackRepository->find($id)->getCover());
        }
        $this->fileSystem->remove('../public/uploads/' . $this->trackRepository->find($id)->getTrackPath());

        $this->entityManager->remove($this->trackRepository->find($id));
        $this->entityManager->flush();

        return array(
            'success' => true,
            'body' => 'Track deleted successfully'
        );
    }
}
