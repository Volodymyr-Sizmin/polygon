<?php

namespace App\Controller;

use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OwnQuestionController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/quest", name="question", methods={"POST"})
     */
    public function yourQuestion(Request $request, Response $response)
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
                404
            );
        }

        $dataQuest = ['question' => $data['question']];
        $dataAnswer = ['answer' => $data['answer']];

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
        $password = ['password' => $token->params['8']->password];

        $tokenId = $this->tokenService->createToken(
            $matchEmail, 
            $matchCode, 
            $dataCodeLifetime, 
            $dataIsBankClient,
            $dataFirst, 
            $dataLast, 
            $dataId, 
            $dataResident,
            $password, 
            $dataQuest, 
            $dataAnswer
        );

        $responseQuest = [
            'success' => true,
            'body' => [
                'message' => 'Ok',
                'token' => "Bearer $tokenId"
                ],
        ];

        header("Authorization: Bearer $tokenId");

        return new JsonResponse($responseQuest, Response::HTTP_CREATED);
    }
}
