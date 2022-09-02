<?php

namespace App\Controller;

use App\Entity\User;
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
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/api/auth/code", name="code", methods={"POST"})
     */
    public function matchCodes(Request $request, ManagerRegistry $doctrine, Response $response)
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $doctrine->getManager();
        $matchingCode = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if ($matchingCode->getCode() != $data['code']) {
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

        $matchingCode->setCounter(2);
        $entityManager->persist($matchingCode);
        $entityManager->flush();

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'Codes match',
                    'cookie' => $response
                ],
            ],
            200
        );
    }
}
