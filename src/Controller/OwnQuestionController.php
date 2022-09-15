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

class OwnQuestionController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

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
                404
            );
        }

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

        $dataQuest = ['question' => $data['question']];
        $dataAnswer = ['answer' => $data['answer']];

        $token = $this->tokenService->decodeToken($data['token']);
        $matchEmail = ['email' => $token->params['0']->email];
        $matchCode = ['code' => $token->params['1']->code];
        $dataCodeLifetime = ['codeLifetime' => $token->params['2']->codeLifetime];
        $dataFirst = ['FirstName' => $token->params['3']->FirstName];
        $dataLast = ['LastName' => $token->params['4']->LastName];
        $dataId = ['Id' => $token->params['5']->Id];
        $password = ['password' => $token->params['6']->password];

        $tokenId = $this->tokenService->createToken($matchEmail, $matchCode, $dataCodeLifetime, $dataFirst, $dataLast, $dataId, $password, $dataQuest, $dataAnswer);

        $responseQuest = [
            'success' => true,
            'body' => [
                'message' => 'Ok',
                'token' => $tokenId
            ]
        ];

        return new JsonResponse($responseQuest, Response::HTTP_CREATED);
    }
}
