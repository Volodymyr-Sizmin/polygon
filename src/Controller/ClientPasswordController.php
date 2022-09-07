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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClientPasswordController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/api/auth/clientpassword", name="clientpassword", methods={"POST"})
     */
    public function passwordMatch(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validatorPass, UserPasswordHasherInterface $passwordHasher, Response $response)
    {
        $data = json_decode($request->getContent(), true);

        if ($data['password'] !== $data['confirm_password']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Passwords do not match',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $user = new User();
        $errors = $validatorPass->validate($user, null, 'password');

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

        $password = ['password' => $data['password']];

        $token = $this->tokenService->decodeToken($data['token']);
        $matchCode = ['code' => $token->params['1']->code];
        $matchEmail = ['email' => $token->params['0']->email];

        $tokenPass = $this->tokenService->createToken($matchEmail, $matchCode, $password);

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'Password saved',
                    'token' => $tokenPass
                ],
            ],
            200
        );
    }
}

