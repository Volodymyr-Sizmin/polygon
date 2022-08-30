<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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
    private $requestStack;

    public function __construct(TokenService $tokenService, RequestStack $requestStack)
    {
        $this->tokenService = $tokenService;
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/api/auth/sendemail", name="email", methods={"POST"})
     */
    public function sendEmail(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);

        $cache = new FilesystemAdapter();

        $session = $this->requestStack->getSession();
        $session->set('email', $data['email']);
        $sesEmail = $session->get('email');

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

        $entityManager = $doctrine->getManager();
        $matchingEmail = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if (empty($matchingEmail)) {
            $data['code'] = rand(100000, 999999);

            $session->set('code', $data['code']);

            $dataEmail = $data['email'];
            $dataCode = $data['code'];

            $token = $this->tokenService->createToken($dataEmail, $dataCode);

            $user = new User();

            $session->set('user', $user);

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

            $emailForSend = (new TemplatedEmail())
            ->from('admin@polybank.com')
            ->to($sesEmail)
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
            $response = [
                'success' => true, 'body' => [
                'message' => 'Email has come',
                'token' => $token,
                ],
            ];

            return new JsonResponse($response, Response::HTTP_CREATED);
        } elseif ($matchingEmail->getEmail() === $data['email']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Hello. A user with this email has already been registered in the system. Please call the number +7 XXX XXXX XXXX or contact the nearest bank office.',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
