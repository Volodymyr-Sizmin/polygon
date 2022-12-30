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

class LoginByIdController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/loginid", name="loginid", methods={"POST"})
     *   @OA\Post(
     *     path="/registration_service/loginid",
     *     tags={"Registration Service"},
     *     description="Login with using passport ID and password",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="passport_id", type="string"),
     *             @OA\Property(property="password", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User successfully authorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(
     *                 property="body",
     *                 type="object",
     *                 @OA\Property(property="message", type="string"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid login or user is not fully registered",
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
     * )
     */
    public function idLogin(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $encoder): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Empty input'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['passport_id' => $data['passport_id']]);

        if (!$user) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $verified = $encoder->isPasswordValid($user, $data['password']);

        if (!$verified) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        if ($user->getFullRegistration() == false) {
            $response = [
                'success' => false,
                'body' => ['message' => 'User is not fully registered'],
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $passId = $user->getPassportId();
        $email = $user->getEmail();
        $token = $this->tokenService->createToken([
            'email' => $email,
            'passport_id' => $passId]);
        header("Authorization: Bearer $token");

        return new JsonResponse([
            'success' => true,
            'token' => "Bearer $token",
            'body' => [
                'message' => 'User successfully authorized',
            ],
        ]);
    }
}
