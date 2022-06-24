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

class ResetController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/api/auth/reset", name="reset", methods={"POST"})
     */
    public function resetById(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Empty input'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $data['reset_code'] = rand(100000, 999999);

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['passport_id' => $data['passport_id']]);
        $user->setResetCode($data['reset_code']);

        if (!$user) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $errors = $validator->validate($user, null, 'code');

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
            ->to($user->getEmail())
            ->subject('Your verification code')
            ->htmlTemplate('index.html.twig')
            ->context([
                'code' => $data['reset_code'],
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
    }
}
