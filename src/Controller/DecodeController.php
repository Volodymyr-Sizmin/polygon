<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DecodeController extends AbstractController
{
    protected $tokenService;

    /**
     * @Route("/api/auth/decode", name="decode", methods={"POST"})
     */
    public function decodeJwtToken(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Empty input'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['token' => $data['token']]);
        if (!$user) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }
        $gotEmail = $user->getEmail();

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => $gotEmail,
                ],
            ],
            200
        );
    }
}
