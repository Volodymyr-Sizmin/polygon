<?php

namespace App\Controller;

use App\Service\MatchCodeService;
use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetCodeController extends AbstractController
{
    protected $tokenService;
    protected MatchCodeService $matchCodeService;

    public function __construct(TokenService $tokenService, MatchCodeService $matchCodeService)
    {
        $this->tokenService = $tokenService;
        $this->matchCodeService = $matchCodeService;
    }

    /**
     * @Route("/registration_service/resetcode", name="resetcode", methods={"POST"})
     */
    public function matchResetCodes(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $session = $request->getSession();
        $attempts = $session->get('attempts', ['attempts' => 2, 'email' => 'null']);

        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));

        $matchCode = $token->data->code;
        $matchEmail = $token->data->email;

        if (!isset($matchCode)) {
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

        if ($matchCode != $data['code']) {
            $this->matchCodeService->matchCode($attempts, $matchEmail, $session);
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'The entered code does not match the one sent to the mailbox',
                    ],
                    'message' => (string) $attempts['attempts'],
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
            Response::HTTP_OK
        );
    }
}
