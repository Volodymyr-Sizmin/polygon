<?php

namespace App\Controller;

use App\Entity\Playlist;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaylistController extends SerializeController
{
    public function createPlaylist(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $playlist = new Playlist();

        $data = json_decode($request->getContent(), true);

        $playlist->setName(isset($data["name"]) ? $data["name"] : $playlist->getName());
        $playlist->setDescription(isset($data["description"]) ? $data["description"] : $playlist->getDescription());
        $playlist->setCreatedAt(new \DateTimeImmutable());
        $playlist->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->persist($playlist);
        $entityManager->flush();

        return JsonResponse::fromJsonString($this->serializeJson($playlist), Response::HTTP_CREATED);
    }

    public function showPlaylist(Playlist $playlist): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializeJson($playlist));
    }

    public function modifyPlaylist(Playlist $playlist, Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);
        $playlist->setName(isset($data["name"]) ? $data["name"] : $playlist->getName());
        $playlist->setDescription(isset($data["description"]) ? $data["description"] : $playlist->getDescription());
        $playlist->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->persist($playlist);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'body' => 'Playlist successfully modified']);
    }

    public function deletePlaylist(Playlist $playlist): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($playlist);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'body' => 'Playlist successfully deleted']);
    }
}
