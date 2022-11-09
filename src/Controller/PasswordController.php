<?php

namespace App\Controller;

use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/password", name="password", methods={"POST"})
     */
    public function passwordMatch(Request $request)
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
        
        $password = ['password' => $data['password']];

        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        
        $matchEmail = ['email' => $token->params['0']->email];
        $matchCode = ['code' => $token->params['1']->code];
        $dataCodeLifetime = ['codeLifetime' => $token->params['2']->codeLifetime];
        $dataIsBankClient = ['isBankClient' => $token->params['3']->isBankClient];
        $dataFirst = ['FirstName' => $token->params['4']->FirstName];
        $dataLast = ['LastName' => $token->params['5']->LastName];
        $dataId = ['Id' => $token->params['6']->Id];
        $dataResident = ['resident' => $token->params['7']->resident];

        $tokenPass = $this->tokenService->createToken(
            $matchEmail, 
            $matchCode, 
            $dataCodeLifetime,
            $dataIsBankClient, 
            $dataFirst, 
            $dataLast, 
            $dataId,
            $dataResident, 
            $password
        );

        header("Authorization: Bearer $tokenPass");
        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'Password saved',
                    'token' => "Bearer $tokenPass"
                ],
                200
            ]
        );
    }
}
