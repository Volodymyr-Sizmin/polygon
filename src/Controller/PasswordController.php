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
        
        $matchEmail = ['email' => $token->aud];
        $matchCode = ['code' => $token->data[1]->code];
        $dataCodeLifetime = ['code_life_time' => $token->data[2]->code_life_time];
        $dataIsBankClient = ['is_bank_client' => $token->data[3]->is_bank_client];
        $dataFirst = ['first_name' => $token->data[4]->first_name];
        $dataLast = ['last_name' => $token->data[5]->last_name];
        $dataId = ['passport_id' => $token->data[6]->passport_id];
        $dataResident = ['resident' => $token->data[7]->resident];

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
                'token' => "Bearer $tokenPass",
                'body' => [
                    'message' => 'Password saved',
                ],
                200
            ]
        );
    }
}
