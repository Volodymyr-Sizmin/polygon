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

class NonClientRegisterController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/nonclient", name="nonclient", methods={"POST"})
     */
    public function nonClientRegister(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator, Response $response)
    {
        $data = json_decode($request->getContent(), true);

        $em = $doctrine->getManager();
        $userId = $em->getRepository(User::class)->findBy(['passport_id' => $data['PassId']]);

        if (!empty($userId)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Hello. A user with this Id has already been registered in the system. Please call the number +7 XXX XXXX XXXX or contact the nearest bank office.',
                        'cookie' => $response
                    ],
                ],
                404
            );
        }

        $user = new User();
        $errors = $validator->validate($user, null, ['name', 'passport']);

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

        $dataFirst = ['FirstName' => $data['FirstName']];
        $dataLast = ['LastName' => $data['LastName']];
        $dataId = ['Id' => $data['PassId']];
        $dataResident = ['resident' => $data['Residence']];

        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $matchEmail = ['email' => $token->aud];
        $matchCode = ['code' => $token->data->code];
        $dataCodeLifetime = ['codeLifetime' => $token->data->code_life_time];
        $dataIsBankClient = ['isBankClient' => $token->data->is_bank_client];

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
