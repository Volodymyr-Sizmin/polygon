<?php

namespace App\Controller;

use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchCodesController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/code", name="code", methods={"POST"})
     */
    public function matchCodes(Request $request)
    {
        $data = json_decode($request->getContent(), true);

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

        $matchCode = $token->data[1]->code;
        $codeLifetime = $token->data[2]->code_life_time;

        if ($matchCode != $data['code']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'The entered code does not match the code sent to the mailbox',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($codeLifetime < time()) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Code has expired',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'Codes match',
                ],
            ],
            200
        );
    }
}
