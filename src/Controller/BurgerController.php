<?php

namespace App\Controller;

use App\Entity\Track;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\SerializeController;

class BurgerController extends SerializeController
{
    public function shareSong(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        if (!is_numeric($data['id']) && $data['id'] < 0) {
            return new JsonResponse(['success' => false, 'Invalid id']);
        }

        if (!$entityManager->getRepository(Track::class)->getTrackPath($data['id'])) {
            return new JsonResponse(['success' => false, 'This track does not found']);
        }

        return new JsonResponse(['success' => true, 'path' => $entityManager
            ->getRepository(Track::class)
            ->getTrackPath($data['id'])]);
    }

    public function getArtist(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        if (!is_numeric($data['id']) && $data['id'] < 0) {
            return new JsonResponse(['success' => false, 'Invalid id']);
        }

        if (!$entityManager->getRepository(Track::class)->getArtistData($data['id'])) {
            return new JsonResponse(['success' => false, 'This Artist does not found']);
        }

         return new JsonResponse(['success' => true, 'information' => $entityManager
            ->getRepository(Track::class)
            ->getArtistData($data['id'])]);
    }

    public function addNextUp(Track $track): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializeJson($track));
    }

    public function getAlbum(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        if (!is_numeric($data['id']) && $data['id'] < 0) {
            return new JsonResponse(['success' => false, 'Invalid id']);
        }

        if (!$entityManager->getRepository(Track::class)->getArtistData($data['id'])) {
            return new JsonResponse(['success' => false, 'This album does not found']);
        }

         return new JsonResponse(['success' => true, 'path' => $entityManager
            ->getRepository(Track::class)
            ->getAlbumSong($data['id'])]);
    }
}
