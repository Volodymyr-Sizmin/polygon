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
    protected $code;

    /**
     * @Route("/api/auth/code", name="code", methods={"POST"})
     */
    public function matchCodes(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);

        $data['code'] = $request->get('code');
        $data['token'] = $request->get('token');

        $repository = $doctrine->getRepository(User::class);

        $matchingCode = $repository->findOneBy(['token' => $data['token']]);

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
