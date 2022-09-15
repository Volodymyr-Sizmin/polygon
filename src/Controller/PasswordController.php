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

class PasswordController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/api/auth/password", name="password", methods={"POST"})
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
                404
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
        
        $matchEmail = ['email' => $token->params['0']->email];
        $matchCode = ['code' => $token->params['1']->code];
        $dataCodeLifetime = ['codeLifetime' => $token->params['2']->codeLifetime];
        $dataFirst = ['FirstName' => $token->params['3']->FirstName];
        $dataLast = ['LastName' => $token->params['4']->LastName];
        $dataId = ['Id' => $token->params['5']->Id];

        $tokenPass = $this->tokenService->createToken($matchEmail, $matchCode, $dataCodeLifetime, $dataFirst, $dataLast, $dataId, $password);

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
