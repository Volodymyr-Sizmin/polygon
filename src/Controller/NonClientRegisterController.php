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
use OpenApi\Annotations as OA;

class NonClientRegisterController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/nonclient", name="nonclient", methods={"POST"})
     * @OA\Post(
     *      path="/registration_service/nonclient",
     *      description="Register as non bank client",
     *      tags={"Registration Service"},
     *      security={{"Bearer": {}}},
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="first_name", type="string"),
     *             @OA\Property(property="last_name", type="string"),
     *             @OA\Property(property="pass_id", type="string"),
     *             @OA\Property(property="residence", type="string")
     *       )
     * ),
     * @OA\Response(
     *         response=201,
     *         description="User has successfully registered",
     *         @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="success", type="boolean"),
     *                @OA\Property(property="token", type="string"),
     *                @OA\Property(
     *                property="body",
     *                type="object",
     *                @OA\Property(property="message", type="string")
     *         )
     *      )
     *   ),
     * @OA\Response(
     *         response=400,
     *         description="User already exists",
     *         @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="success", type="boolean"),
     *                @OA\Property(
     *                property="message",
     *                type="string",
     *                @OA\Property(property="message", type="string")
     *         )
     *      )
     *   ),
     * @OA\Response(
     *         response=401,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="success", type="boolean"),
     *                @OA\Property(
     *                property="body",
     *                type="object",
     *                @OA\Property(property="message", type="string")
     *         )
     *      )
     *   )
     * )
     */
    public function nonClientRegister(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator, Response $response)
    {
        $data = json_decode($request->getContent(), true);

        $em = $doctrine->getManager();
        $userId = $em->getRepository(User::class)->findBy(['passport_id' => $data['pass_id']]);

        if (!empty($userId) && $userId[0]->getFullRegistration()) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'the user already exists',
                ],
                400
            );
        }

        $user = new User();
        $errors = $validator->validate($user, null, ['name', 'passport']);

        if (count($errors) > 0) {
            $errorsStringPass = (string)$errors;

            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => $errorsStringPass,
                    ],
                ],
                Response::HTTP_BAD_REQUEST);
        }

        $dataFirst = ['first_name' => $data['first_name']];
        $dataLast = ['last_name' => $data['last_name']];
        $dataId = ['passport_id' => $data['pass_id']];
        $dataResident = ['resident' => $data['residence']];

        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $matchEmail = ['email' => $token->data->email];
        $matchCode = ['code' => $token->data->code];
        $dataCodeLifetime = ['code_life_time' => $token->data->code_life_time];
        $dataIsBankClient = ['is_bank_client' => $token->data->is_bank_client];

        $tokenId = $this->tokenService->createToken(
            $matchEmail,
            $matchCode,
            $dataCodeLifetime,
            $dataIsBankClient,
            $dataFirst,
            $dataLast,
            $dataId,
            $dataResident
        );

        $response = [
            'success' => true,
            'token' => "Bearer $tokenId",
            'body' => [
                'message' => 'Ok'
            ],
        ];
        header("Authorization: Bearer $tokenId");
        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
