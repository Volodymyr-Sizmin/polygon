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

class ClientQuestionController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/api/auth/clientquest", name="clientquestion", methods={"POST"})
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
                Response::HTTP_BAD_REQUEST
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

        $dataArray = [
            'question' => $data['question'],
            'answer' => $data['answer']
        ];

        $token1 = $this->tokenService->createToken($dataArray);

        $dataQuest = ['question' => $data['question']];
        $dataAnswer = ['answer' => $data['answer']];

        $token = $this->tokenService->decodeToken($data['token']);
        $matchCode = ['code' => $token->params['1']->code];
        $matchEmail = ['email' => $token->params['0']->email];
        $password = ['password' => $token->params['2']->password];

        $tokenId = $this->tokenService->createToken($matchEmail, $matchCode, $password, $dataQuest, $dataAnswer);

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

