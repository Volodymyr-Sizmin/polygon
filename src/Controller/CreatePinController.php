<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreatePinController extends AbstractController
{
    /**
     * @Route("/api/auth/createpin", name="createpin", methods={"POST"})
     */
    public function createPin(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Empty input'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $entityManager = $doctrine->getManager();
        $storedUser = $entityManager->getRepository(User::class)->findOneBy(['token' => $data['token']]);

        if (!$storedUser) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Something went wrong'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $storedUser->setPin($data['pin']);

        $errors = $validator->validate($storedUser, null, 'pin');

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => $errorsString,
                    ],
                ],
                Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($storedUser);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'body' => [
                'message' => "Pin code created",
            ],
        ]);
    }

    /**
     * @Route("/api/auth/confpin", name="confirmpin", methods={"POST"})
     */

    public function confPin(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Empty input'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $entityManager = $doctrine->getManager();
        $matchingPin = $entityManager->getRepository(User::class)->findOneBy(['token' => $data['token']]);

        if (!$matchingPin) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Something went wrong'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        if ($matchingPin->getPin() != $data['confirm_pin']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => "Pin doesn't match",
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
