<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaveRegisterDataController extends AbstractController
{
    /**
     * @Route("/api/auth/savedata", name="savedata", methods={"POST"})
     */
    public function savedata(Request $request, ManagerRegistry $doctrine): Response
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Empty input',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        $user = new User();

        $user->setEmail($data['email']);
        $user->setCode($data['code']);
        $user->setPassword($data['password']);
        $user->setQuestion($data['question']);
        $user->setAnswer($data['answer']);

        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();

        $response = ['success' => true, 'body' => ['message' => ['Data is saved']]];

        return new JsonResponse($response, Response::HTTP_CREATED);

    }
}
