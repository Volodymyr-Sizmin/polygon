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
    protected $email;
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
                    Response::HTTP_BAD_REQUEST
                );
        }
        $repository = $doctrine->getRepository(User::class);

        $matchingEmail = $repository->findOneBy(['email' => $data['email']]);
        if (empty($matchingEmail)) {
            $data['code'] = rand(100000, 999999);

            $token = $this->tokenService->createToken($data);

            $user = new User();

            $user->setEmail($data['email']);
            $user->setCode($data['code']);
            $user->setToken($token);

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

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

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

            $dsn = 'smtp://mailhog:1025';
            $transport = Transport::fromDsn($dsn);
            $mailer = new Mailer($transport);
            $mailer->send($emailForSend);
            $response = ['success' => true, 'message' => ['Email has come']];

            return new JsonResponse($response, Response::HTTP_CREATED);
        } elseif ($matchingEmail->getEmail() === $data['email']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'A user with this email has already been registered in the system. Please call the number +7 XXX XXXX XXXX or contact the nearest bank office.',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
