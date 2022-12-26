<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\CookieService;
use App\Service\MatchCodeService;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchCodesController extends AbstractController
{
    protected $tokenService;
    protected $cookieService;
    protected $matchCodeService;

    public function __construct(TokenService $tokenService, CookieService $cookieService, MatchCodeService $matchCodeService)
    {
        $this->tokenService = $tokenService;
        $this->cookieService = $cookieService;
        $this->matchCodeService = $matchCodeService;
    }

    /**
     * @Route("/registration_service/code", name="code", methods={"POST"})
     */
    public function matchCodes(Request $request, ManagerRegistry $doctrine)
    {
        $data = json_decode($request->getContent(), true);

        $authorizationHeader = $request->headers->get('Authorization');

        if (!isset($authorizationHeader)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Empty token field in request header',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));

        $matchCode = $token->data->code;
        $codeLifetime = $token->data->code_life_time;
        $matchEmail = $token->data->email;

        $session = $request->getSession();
        $attempts = $session->get('attempts', ['attempts' => 2, 'email' => 'null']);

        if ($matchCode != $data['code']) {
            $this->matchCodeService->matchCode($attempts, $matchEmail, $session);
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'The entered code does not match the code sent to the mailbox',
                    ],
                    'message' => reset($attempts),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($codeLifetime < time()) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Code has expired',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $em = $doctrine->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $matchEmail]);

        if (isset($user)) {
            $user->setEmail($matchEmail);
            $em->merge($user);
        } else {
            $user = new User();
            $user->setEmail($matchEmail);
            $em->persist($user);
        }
        $em->flush();

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'Code matched',
                ],
                'message' => $attempts['attempts'],
            ],
            200
        );
    }
}
