<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;

class ResetPasswordController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/newpassword", name="newpassword", methods={"POST"})
     * @OA\Post(
     *      path="/registration_service/newpassword",
     *      tags= {"Registration Service"},
     *      security={{"Bearer": {}}},
     *      description="Reset password:create new password",
     *      @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="confirm_password", type="string"),
     *         )
     *     ),
     * @OA\Response(
     *         response=200,
     *         description="Password saved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="body",
     *                 type="object",
     *                 @OA\Property(property="message", type="string"),
     *             )
     *         )
     *    ),
     *  @OA\Response(
     *         response=400,
     *         description="Passwords do not match",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="body",
     *                 type="object",
     *                 @OA\Property(property="message", type="string"),
     *             )
     *         )
     *      )
     *    )
     */
    public function passwordMatch(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher)
    {
        $data = json_decode($request->getContent(), true);

        $authorizationHeader = $request->headers->get('Authorization');

        if ($data['password'] !== $data['confirm_password']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Passwords do not match',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $dataPass = [
            'password' => $data['password'],
        ];

        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $email = $token->aud;
        $matchCode = ['code' => $token->data->code];
        $matchEmail = ['email' =>$email];

        $tokenPass = $this->tokenService->createToken($matchEmail, $matchCode, $dataPass);

        $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $email]);
        
        $hashedPass = $passwordHasher->hashPassword(
            $user,
            $data['password']
        );

        $user->setPassword($hashedPass);
        
        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();

        header("Authorization: Bearer $tokenPass");
        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'Password saved'
                ],
            ],
            200
        );
    }
}
