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

class ResetPasswordController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/api/auth/newpassword", name="newpassword", methods={"POST"})
     */
    public function passwordMatch(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validatorPass)
    {
        $data = json_decode($request->getContent(), true);

        $authorizationHeader = $request->headers->get('Authorization');

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

//        $entityManager = $doctrine->getManager();
//        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
//
//        if (!$user) {
//            throw $this->createNotFoundException('No user found for email '.$data['email']);
//        }
//
//        $user->setPassword($data['password']);
//

        $dataPass = [
            'password' => $data['password'],
        ];

        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $matchCode = ['code' => $token->params['0']->code];
        $matchEmail = ['email' =>$token->params['1']->email];

        $tokenPass = $this->tokenService->createToken($matchCode, $matchEmail, $dataPass);

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
