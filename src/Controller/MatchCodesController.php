<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MatchCodesController extends AbstractController
{
    /**
     * @Route("/api/auth/code", name="code", methods={"POST"})
     */
    public function matchCodes(Request $request, ManagerRegistry $doctrine)
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['token' => $data['token']]);

        if ($user->getCode() != $data['code']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Введенный код не совпадает с присланным на почтовый ящик',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'Codes match',
                ],
            ],
            200
        );
    }
}

