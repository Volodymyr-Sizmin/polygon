<?php

namespace App\Controller;

use App\Service\MatchCodeService;
use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class ResetCodeController extends AbstractController
{
    protected $tokenService;
    protected $matchCodeService;

    public function __construct(TokenService $tokenService, MatchCodeService $matchCodeService)
    {
        $this->tokenService = $tokenService;
        $this->matchCodeService = $matchCodeService;
    }

    /**
     * @Route("/registration_service/resetcode", name="resetcode", methods={"POST"})
     * @OA\Post(
     *     path="/registration_service/resetcode",
     *     tags={"Registration Service"},
     *     security={{"Bearer": {}}},
     *     description="Reset password:check verification code",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="string"),
     *         )
     *     ),
     * @OA\Response(
     *         response=200,
     *         description="Codes match",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="body",
     *                 type="object",
     *                 @OA\Property(property="message", type="string"),
     *             )
     *         )
     *     ),
     * @OA\Response(
     *         response=400,
     *         description="Введенный код не совпадает с присланным на почтовый ящик",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="body",
     *                 type="object",
     *                 @OA\Property(property="message", type="string"),
     *             )
     *         )
     *     )
     *  )
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
