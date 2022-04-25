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

    public function indexService(): array
    {
        return $this->trackRepository->findAll();
    }

    /**
     * @return array|mixed
     */
    public function createService(): array
    {
        return [[
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
                'Lounge',
            ],
        ]];
    }

    /**
     * @param \App\DTO\TracklistDTO $tracklistDTO
     *
     * @throws \App\Exception\FileUploadException
     */
    public function storeService($tracklistDTO): Track
    {
        $track = new Track();

        if (null !== $tracklistDTO->album) {
            $track->setAlbum($tracklistDTO->album);
        }

        if (null !== $tracklistDTO->cover) {
            $track->setCover($this->fileUploader->upload($tracklistDTO->cover)->getPath());
        }

        if (null !== $tracklistDTO->track_path) {
            $track->setTrackPath($this->fileUploader->upload($tracklistDTO->track_path)->getPath());
        }

        if (null !== $tracklistDTO->title) {
            $track->setTitle($tracklistDTO->title);
        }

        if (null !== $tracklistDTO->author) {
            $track->setAuthor($tracklistDTO->author);
        }

        if (null !== $tracklistDTO->type) {
            $track->setType($tracklistDTO->type);
        }

        if (null !== $tracklistDTO->genre) {
            $track->setGenre($tracklistDTO->genre);
        }

        $this->entityManager->persist($track);
        $this->entityManager->flush();

        return $track;
    }

    /**
     * @throws MyTracklistException
     */
    public function showService(int $id): object
    {
        if (null === $this->trackRepository->find($id)) {
            throw new MyTracklistException('Can not find track');
        }

        return $this->trackRepository->find($id);
    }

    /**
     * @throws MyTracklistException
     */
    public function editService(int $id): object
    {
        if (null === $this->trackRepository->find($id)) {
            throw new MyTracklistException('Can not find track');
        }

        return $this->trackRepository->find($id);
    }

    /**
     * @param \App\DTO\TracklistDTO $tracklistDTO
     * @param int                   $id
     *
     * @throws MyTracklistException
     */
    public function updateService($tracklistDTO, $id): Track
    {
        if (null === $this->trackRepository->find($id)) {
            throw new MyTracklistException('Can not find track');
        }

        $track = $this->trackRepository->find($id);
        if (null !== $tracklistDTO->cover) {
            $this->fileSystem->remove('../public/uploads/'.$track->getCover());
            $track->setCover($this->fileUploader->upload($tracklistDTO->cover)->getPath());
        }

        if (null !== $tracklistDTO->album) {
            $track->setAlbum($tracklistDTO->album);
        }

        if (null !== $tracklistDTO->title) {
            $track->setTitle($tracklistDTO->title);
        }

        if (null !== $tracklistDTO->author) {
            $track->setAuthor($tracklistDTO->author);
        }

        if (null !== $tracklistDTO->type) {
            $track->setType($tracklistDTO->type);
        }

        if (null !== $tracklistDTO->genre) {
            $track->setGenre($tracklistDTO->genre);
        }

        $this->entityManager->flush();

        return $track;
    }

    /**
     * @throws MyTracklistException
     */
    public function deleteService(int $id): array
    {
        if (null === $this->trackRepository->find($id)) {
            throw new MyTracklistException('Can not find track');
        }

        if (null !== $this->trackRepository->find($id)->getCover()) {
            $this->fileSystem->remove('../public/uploads/'.$this->trackRepository->find($id)->getCover());
        }
        $this->fileSystem->remove('../public/uploads/'.$this->trackRepository->find($id)->getTrackPath());

        $this->entityManager->remove($this->trackRepository->find($id));
        $this->entityManager->flush();

        return [
            'success' => true,
            'body' => 'Track deleted successfully',
        ];
    }
}
