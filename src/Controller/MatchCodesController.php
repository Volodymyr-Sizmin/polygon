<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchCodesController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/api/auth/code", name="code", methods={"POST"})
     */
    public function matchCodes(Request $request, ManagerRegistry $doctrine, Response $response)
    {
        $data = json_decode($request->getContent(), true);

        $token = $this->tokenService->decodeToken($data['token']);
        $matchCode = $token->params['1']->code;

//        $entityManager = $doctrine->getManager();
//        $matchingCode = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if ($matchCode != $data['code']) {
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

//        $matchingCounter = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
//        $counter = $matchingCounter->getCounter();
//        $matchingCounter->setCounter($counter + 1);
//
//        $entityManager->persist($matchingCode);
//        $entityManager->flush();

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
