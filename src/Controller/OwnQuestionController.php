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

class OwnQuestionController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/quest", name="question", methods={"POST"})
     */
    public function yourQuestion(Request $request, Response $response, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher)
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Empty input',
                    ],
                ],
                404
            );
        }

        $dataQuest = ['question' => $data['question']];
        $dataAnswer = ['answer' => $data['answer']];

        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $matchEmail = ['email' => $token->data[0]->email];
        $matchCode = ['code' => $token->data[1]->code];
        $dataCodeLifetime = ['code_life_time' => $token->data[2]->code_life_time];
        $dataIsBankClient = ['is_bank_client' => $token->data[3]->is_bank_client];
        $dataFirst = ['first_name' => $token->data[4]->first_name];
        $dataLast = ['last_name' => $token->data[5]->last_name];
        $dataId = ['pass_id' => $token->data[6]->pass_id];
        $dataResident = ['residence' => $token->data[7]->residence];
        $password = ['password' => $token->data[8]->password];

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
        $user->setPassword(implode($password));
        $user->setAnswer(implode($dataAnswer));
        $user->setQuestion(implode($dataQuest));
        $user->setFullRegistration(true);

        if (isset($userFirstName) || isset($userLastName) || isset($userPassId) || isset($userResidence)) {
            $em->merge($user);
        } else {
            $em->persist($user);
        }
        $em->flush();

        $tokenId = $this->tokenService->createToken(
            $matchEmail,
            $matchCode,
            $dataCodeLifetime,
            $dataIsBankClient,
            $dataFirst,
            $dataLast,
            $dataId,
            $dataResident,
            $password,
            $dataQuest,
            $dataAnswer
        );

        $responseQuest = [
            'success' => true,
            'token' => "Bearer $tokenId",
            'body' => [
                'message' => 'Ok',
            ],
        ];

        header("Authorization: Bearer $tokenId");

        return new JsonResponse($responseQuest, Response::HTTP_CREATED);
    }
}
