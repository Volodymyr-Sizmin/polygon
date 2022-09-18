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
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
     * @Route("/api/auth/sendemail", name="email", methods={"POST"})
     */
    public function sendEmail(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator)
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
        $matchingEmail = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if (empty($matchingEmail)) {
            $user = new User();

            $errors = $validator->validate($user, null, 'registration');

            if (count($errors) > 0) {
                $errorsString = (string) $errors;

                return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => $errorsString,
                    ],
                ],
                Response::HTTP_BAD_REQUEST);
            }

            $data['code'] = rand(100000, 999999);
            $dataEmail = ['email' => $data['email']];
            $dataCode = ['code' => $data['code']];
            $dataCodeLifetime = ['codeLifetime' => time() + 600];

            $token = $this->tokenService->createToken($dataEmail, $dataCode, $dataCodeLifetime);

            $emailForSend = (new TemplatedEmail())
            ->from('admin@polybank.com')
            ->to($data['email'])
            ->subject('Your verification code')
            ->htmlTemplate('index.html.twig')
            ->context([
                'code' => $data['code'],
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
                'success' => true, 'body' => [
                'message' => 'Email has come',
                'token' => $token,
                ],
            ];

            return new JsonResponse($responseEmail, Response::HTTP_CREATED);
        } else {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Hello. A user with this email has already been registered in the system. Please call the number +7 XXX XXXX XXXX or contact the nearest bank office.',
                    ],
                ],
                404
            );
        }
    }
}
