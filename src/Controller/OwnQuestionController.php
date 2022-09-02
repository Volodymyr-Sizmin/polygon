<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OwnQuestionController extends AbstractController
{
    /**
     * @Route("/api/auth/quest", name="question", methods={"POST"})
     */
    public function yourQuestion(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator, Response $response)
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

        $entityManager = $doctrine->getManager();
        $matchingEmail = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        $user = new User();

        $errors = $validator->validate($user, null, ['quest']);

        if (count($errors) > 0) {
            $errorsStringPass = (string) $errors;

            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => $errorsStringPass,
                    ],
                ],
                Response::HTTP_BAD_REQUEST);
        }

        $counter = $matchingEmail->getCounter();

        $matchingEmail->setQuestion($data['question']);
        $matchingEmail->setAnswer($data['answer']);
        $matchingEmail->setCounter($counter + 1);

        $entityManager->persist($matchingEmail);
        $entityManager->flush();

        $responseQuest = [
            'success' => true,
            'body' => [
                'message' => 'Ok'
            ]
        ];

        return new JsonResponse($responseQuest, Response::HTTP_CREATED);
    }
}
