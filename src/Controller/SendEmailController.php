<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SendEmailController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/sendemail", name="email", methods={"POST"})
     */
    public function sendEmail(Request $request, Response $response, ManagerRegistry $doctrine)
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['email'])) {
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

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if ($user && $user->getQuestion()) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Hello. A user with this email has already been registered in the system. Please call the number +7 XXX XXXX XXXX or contact the nearest bank office.',
                    ],
                ],
                404
            );
        } else {
            $isBankClient = ($user && !$user->getQuestion()) ? true : false;
            $code = rand(100000, 999999);
            $dataEmail = ['email' => $data['email']];
            $dataCode = ['code' => $code];
            $dataCodeLifetime = ['code_life_time' => time() + 600];
            $dataIsBankClient = ['is_bank_client' => $isBankClient];

            if ($isBankClient) {
                $dataFirst = ['first_name' => $user->getFirstName()];
                $dataLast = ['last_name' => $user->getLastName()];
                $dataId = ['pass_id' => $user->getPassportId()];
                $dataResident = ['resident' => $user->getResident()];

                $token = $this->tokenService->createToken(
                    $dataEmail,
                    $dataCode,
                    $dataCodeLifetime,
                    $dataIsBankClient,
                    $dataFirst,
                    $dataLast,
                    $dataId,
                    $dataResident
                );
            } else {
                $token = $this->tokenService->createToken($dataEmail, $dataCode, $dataCodeLifetime, $dataIsBankClient);
            }

            $emailForSend = (new TemplatedEmail())
                ->from('admin@polybank.com')
                ->to($data['email'])
                ->subject('Your verification code')
                ->htmlTemplate('index.html.twig')
                ->context([
                        'code' => $code,
                        'token' => $token,
                    ]);

            $loader = new FilesystemLoader('/');

            $twigEnv = new Environment($loader);

            $twigBodyRenderer = new BodyRenderer($twigEnv);

            $twigBodyRenderer->render($emailForSend);

            $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
            $mailer = new Mailer($transport);
            $mailer->send($emailForSend);

            $responseEmail = [
                'success' => true,
                'token' => "Bearer $token",
                'body' => [
                    'message' => 'Email has come'
                ]
            ];

            header("Authorization: Bearer $token");
            return new JsonResponse($responseEmail, Response::HTTP_CREATED);
        }
    }
}
