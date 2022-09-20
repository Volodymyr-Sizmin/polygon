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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SaveNonBankClientDataController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/api/auth/savenondata", name="nondata", methods={"POST"})
     */
    public function savedata(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validatorPass, UserPasswordHasherInterface $passwordHasher): Response
    {
        $data = json_decode($request->getContent(), true);

        $token = $this->tokenService->decodeToken($data['token']);
        $matchEmail = implode(['email' => $token->params['0']->email]);
        $dataFirst = implode(['FirstName' => $token->params['3']->FirstName]);
        $dataLast = implode(['LastName' => $token->params['4']->LastName]);
        $dataId = implode(['Id' => $token->params['5']->Id]);
        $password = implode(['email' => $token->params['6']->password]);
        $dataQuest = implode(['Question' => $token->params['7']->question]);
        $dataAnswer = implode(['answer' => $token->params['8']->answer]);

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

        $hashedPass = $passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setEmail($matchEmail);
        $user->setFirstName($dataFirst);
        $user->setLastName($dataLast);
        $user->setPassportId($dataId);
        $user->setPassword($hashedPass);
        $user->setQuestion($dataQuest);
        $user->setAnswer($dataAnswer);

        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();

        $response = ['success' => true, 'body' => ['message' => ['Data is saved']]];

        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
