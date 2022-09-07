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
        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));

        $password = implode(['password' => $token->params['2']->password]);


        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $token->params['1']->email]);

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
