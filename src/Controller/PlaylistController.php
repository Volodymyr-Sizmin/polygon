<?php

namespace App\Controller;

use App\Entity\Playlist;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\SerializeController;

class PlaylistController extends SerializeController
{
    public function createPlaylist(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $playlist = new Playlist();
        $playlist->setName($request->query->get('name'));
        $playlist->setCreatedAt(new \DateTimeImmutable());
        $playlist->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->persist($playlist);
        $entityManager->flush();

        $response = JsonResponse::fromJsonString($this->serializeJson($playlist), 201);
        return $response;
    }

    public function showPlaylist(Playlist $playlist): JsonResponse
    {
        $response = JsonResponse::fromJsonString($this->serializeJson($playlist));
        return $response;
    }

    public function modifyPlaylist(Playlist $playlist, Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $playlist->setName($request->query->get('name'));
        $playlist->setUpdatedAt(new \DateTimeImmutable());
        $entityManager->flush();

        $response = new JsonResponse(['success' => true, 'body' => 'Playlist successfully modified']);
        return $response;
    }

    public function deletePlaylist(Playlist $playlist): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($playlist);
        $entityManager->flush();

        $response = new JsonResponse(['success' => true, 'body' => 'Playlist successfully deleted']);
        return $response;
    }
}
