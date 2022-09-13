<?php

namespace App\Controller;

use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        header('Access-Control-Allow-Origin: *');

        header('Access-Control-Allow-Methods: GET, POST');

        header("Access-Control-Allow-Headers: X-Requested-With");

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
