<?php

namespace App\Controller;

use App\Entity\Track;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonDecode;

class BurgerController extends AbstractController
{
    private function shareSong(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $data = json_encode($request->getContent(), true);

        if (!is_numeric($data['id']) && $data['id'] < 0) {
            return new JsonResponse(['success' => false, 'Invalid id']);
        }

        $path = $entityManager->getRepository(Track::class)->getTrackPath($data['id']);

        return new JsonResponse(['success' => true, 'path' => $path]);
    }

    private function getArtist(Request $request): JsonResponse
    {

    }
}
