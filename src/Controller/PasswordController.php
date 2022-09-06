<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PasswordController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/api/auth/password", name="password", methods={"POST"})
     */
    public function passwordMatch(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validatorPass, UserPasswordHasherInterface $passwordHasher, Response $response)
    {
        $data = json_decode($request->getContent(), true);

//        $entityManager = $doctrine->getManager();
//        $matchingPass = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
//
//        if (empty($matchingPass)) {
//            return new JsonResponse(
//                [
//                    'success' => false,
//                    'body' => [
//                        'message' => 'Empty input',
//                    ],
//                ],
//                Response::HTTP_BAD_REQUEST
//            );
//        }

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

        $user = new User();
        $errors = $validatorPass->validate($user, null, 'password');

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

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $data['password']
        );

        $password = ['password' => $data['password']];

        $token = $this->tokenService->decodeToken($data['token']);
        $matchCode = ['code' => $token->params['1']->code];
        $matchEmail = ['email' => $token->params['0']->email];
        $dataFirst = ['FirstName' => $token->params['2']->FirstName];
        $dataLast = ['LastName' => $token->params['3']->LastName];
        $dataId = ['Id' => $token->params['4']->Id];

        $tokenPass = $this->tokenService->createToken($matchEmail, $matchCode, $password, $dataFirst, $dataLast, $dataId);

//        $counter = $matchingPass->getCounter();
//
//        $matchingPass->setPassword($hashedPassword);
//        $matchingPass->setCounter($counter + 1);
//
//        $entityManager->persist($matchingPass);
//        $entityManager->flush();

        return new JsonResponse(
    [
        'success' => true,
        'body' => [
            'message' => 'Password saved',
            'token' => $tokenPass
        ],
    ],
    200
        );
    }
}
