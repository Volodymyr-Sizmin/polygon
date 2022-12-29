<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class PasswordController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/password", name="password", methods={"POST"})
     *     @OA\Post(
     *     path="/registration_service/password",
     *     tags={"Registration Service"},
     *     description="Match password and send",
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="confirm_password", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password saved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="body",
     *                 type="object",
     *                 @OA\Property(property="message", type="string"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Passwords do not match",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="body",
     *                 type="object",
     *                 @OA\Property(property="message", type="string"),
     *             ),
     *         ),
     *      ),
     *    )
     */
    public function passwordMatch(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher)
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

        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));

        $matchEmail = ['email' => $token->data->email];
        $matchCode = ['code' => $token->data->code];
        $dataCodeLifetime = ['code_life_time' => $token->data->code_life_time];
        $dataIsBankClient = ['is_bank_client' => $token->data->is_bank_client];
        $dataFirst = ['first_name' => $token->data->first_name];
        $dataLast = ['last_name' => $token->data->last_name];
        $dataId = ['passport_id' => $token->data->passport_id];
        $dataResident = ['resident' => $token->data->resident];

        $em = $doctrine->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $matchEmail]);
        $userFirstName = $user->getFirstName();
        $userLastName = $user->getLastName();
        $userPassId = $user->getPassportId();
        $userResidence = $user->getResident();

        $user->setFirstName(implode($dataFirst));
        $user->setLastName(implode($dataLast));
        $user->setPassportId(implode($dataId));
        $user->setResident(implode($dataResident));

        $password = ['password' => $passwordHasher->hashPassword($user, $data['password'])];

        if (isset($userFirstName) || isset($userLastName) || isset($userPassId) || isset($userResidence)) {
            $em->merge($user);
        } else {
            $em->persist($user);
        }
        $em->flush();

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
