<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SaveResetPasswordController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/api/auth/savereset", name="savereset", methods={"POST"})
     */
    public function savedata(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validatorPass, UserPasswordHasherInterface $passwordHasher): Response
    {
        $data = json_decode($request->getContent(), true);

        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));

        $matchCode = implode(['code' => $token->params['0']->code]);
        $password = implode(['password' => $token->params['2']->password]);


//        if (empty($sesEmail && $sesCode && $sesPass && $sesQuest && $sesAnswer)) {
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

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $token->params['1']->email]);

        $errors = $validatorPass->validate($user, null, 'password');

//        if (count($errors) > 0) {
//            $errorsStringPass = (string) $errors;
//
//            return new JsonResponse(
//                [
//                    'success' => false,
//                    'body' => [
//                        'message' => $errorsStringPass,
//                    ],
//                ],
//                Response::HTTP_BAD_REQUEST);
//        }

        $hashedPass = $passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setPassword($hashedPass);

        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();

        $response = ['success' => true, 'body' => ['message' => ['Data is saved']]];

        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
