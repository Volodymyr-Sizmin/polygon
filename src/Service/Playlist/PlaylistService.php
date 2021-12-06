<?php

namespace App\Service\Playlist;

use App\Entity\Playlist;
use App\Interfaces\Playlist\PlaylistServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PlaylistService implements PlaylistServiceInterface
{

    private $enityManager;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->enityManager = $em;
        $this->playlist     = $this->enityManager->getRepository(Playlist::class);
        $this->validator    = $validator;
    }

    public function indexService(): array
    {
        return  $this->playlist->findAll();
    }

    /** Create Playlist
     *
     * @param array $data
     * @throws \InvalidArgumentException If passed data is empty
     * @return Playlist
     */
    public function createPlaylist(array $data)
    {
        if (empty($data)) {
            throw new InvalidArgumentException('Empty data');
        }

        $playlist = new Playlist();

        $playlist->setName(isset($data["name"]) ? $data["name"] : $playlist->getName());
        $playlist->setDescription(isset($data["description"]) ? $data["description"] : $playlist->getDescription());
        $playlist->setCreatedAt(new \DateTimeImmutable());
        $playlist->setUpdatedAt(new \DateTimeImmutable());

        $errors = $this->validator->validate($playlist);
        if (count($errors) > 0) {
            return ['errors' => (string) $errors];
        }

        $this->enityManager->persist($playlist);
        $this->enityManager->flush();

        return $playlist;
    }

    /** Modify Playlist
     *
     * @param array $data
     * @throws \InvalidArgumentException If no playlist is passed or data is empty
     * @return array|Playlist Returns instance of Playlist or an array with error messages
     */
    public function modifyPlaylist(Playlist $playlist, array $data): Playlist
    {
        if (!is_a($playlist, Playlist::class)) {
            throw new InvalidArgumentException('Invalid parameter passed. Playlist is required.');
        }

        if (empty($data)) {
            throw new InvalidArgumentException('Empty data');
        }

        if (!empty($data['name'])) {
            $playlist->setName($data['name']);
        }
        if (!empty($data['description'])) {
            $playlist->setDescription($data['description']);
        }

        $errors = $this->validator->validate($playlist);
        if (count($errors) > 0) {
            return ['errors' => (string) $errors];
        }

        $this->enityManager->persist($playlist);
        $this->enityManager->flush();

        return $playlist;
    }

    /** Delete Playlist
     *
     * @param Playlist $playlist
     * @throws \InvalidArgumentException If no playlist is passed
     * @return void
     */
    public function deletePlaylist(Playlist $playlist): void
    {
        if (!is_a($playlist, Playlist::class)) {
            throw new InvalidArgumentException('Invalid parameter passed. Playlist is required.');
        }

        $this->enityManager->remove($playlist);
        $this->enityManager->flush();
    }
    
}