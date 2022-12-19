<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/login", name="login", methods={"POST"})
     */
    public function emailLogin(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $encoder): Response
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
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if (!$user) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        if (empty($user->getPassword())) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Password doesn\'t exist'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $verified = $encoder->isPasswordValid($user, $data['password']);

        if (!$verified) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $email = $user->getEmail();
        $resident = $user->getResident();
        $passportId = $user->getPassportId();

        if ($user->getFullRegistration()) {
            $token = $this->tokenService->createToken(
                ['email' => $email],
                ['resident' => $resident],
                ['passport_id' => $passportId]
            );
            header("Authorization: Bearer $token");
            return new JsonResponse([
                'success' => true,
                'token' => "Bearer $token",
                'body' => [
                    'message' => 'User successfully authorized',
                ],
            ]);
        }
        return new JsonResponse([
            'success' => false,
            'body' => [
                'message' => 'User isn\'t fully registered',
            ]
        ], Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @Route("/registration_service/{email}", name="loginEmail", methods={"GET"})
     */
    public function login(Request $request, ManagerRegistry $doctrine, $email): JsonResponse
    {
        $authorizationHeader = $request->headers->get('Authorization');

        if (!isset($authorizationHeader)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Empty token field in request header',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $tokenEmail = $token->aud;

        if ($tokenEmail !== $email) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Invalid Email',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $tokenEmail]);

        return new JsonResponse([
            'answer' => $user->getAnswer(),
            'email' => $tokenEmail,
            'firstName' => $user->getFirstName(),
            'id' => $user->getId(),
            'lastName' => $user->getLastName(),
            'passportId' => $user->getPassportId(),
            'question' => $user->getQuestion(),
            'residence' => $user->getResident(),
            'roles' => $user->getRoles(),
        ],
            Response::HTTP_OK
        );
    }
}
