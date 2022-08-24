<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaveNonBankClientDataController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/api/auth/savenondata", name="nondata", methods={"POST"})
     */
    public function savedata(Request $request, ManagerRegistry $doctrine): Response
    {
        $session = $this->requestStack->getSession();
        $sesEmail = $session->get('email');
        $sesCode = $session->get('code');
        $sesFirstName = $session->get('firstName');
        $sesLastName = $session->get('lastName');
        $sesPassId = $session->get('passId');
        $sesPass = $session->get('password');
        $sesQuest = $session->get('question');
        $sesAnswer = $session->get('answer');
        $zero = 0;

        if (empty($sesEmail && $sesCode && $sesPass && $sesQuest && $sesAnswer && $sesPassId && $sesFirstName && $sesLastName)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Empty input',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $user = $session->get('user');

        $user->setEmail($sesEmail);
        $user->setCode($sesCode);
        $user->setFirstName($sesFirstName);
        $user->setLastName($sesLastName);
        $user->setPassportId($sesPassId);
        $user->setPassword($sesPass);
        $user->setQuestion($sesQuest);
        $user->setAnswer($sesAnswer);
        $user->setToken($zero);

        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();

        $response = ['success' => true, 'body' => ['message' => ['Data is saved']]];

        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
