<?php

namespace App\Controller;

use App\Entity\User;
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

class ResetPinController extends AbstractController
{
    public function receivePin(Request $request, ManagerRegistry $doctrine)
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
                Response::HTTP_BAD_REQUEST
            );
        }
        $repository = $doctrine->getRepository(User::class);

        $matchingPin = $repository->findOneBy(['token' => $data['token']]);

        if ($matchingPin->getPin() != $data['PIN']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Wrong PIN',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'PIN match',
                ],
            ],
            200
        );
    }

    /**
     * @Route("/api/auth/receiveId", name="receiveId", methods={"POST"})
     */
    public function recieveId(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator)
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
            $errorsString = (string)$errors;

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

    /**
     * @Route("/api/auth/matchPin", name="matchPin", methods={"POST"})
     */
    public function matchPin(Request $request, ManagerRegistry $doctrine)
    {
        $data = json_decode($request->getContent(), true);

        $repository = $doctrine->getRepository(User::class);

        $matchingCode = $repository->findOneBy(['token' => $data['token']]);

        if ($matchingCode->getResetCode() != $data['reset_code']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Введенный код не совпадает с присланным на почтовый ящик',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'Codes match',
                ],
            ],
            200
        );
    }

    /**
     * @Route("/api/auth/newPin", name="newPin", methods={"POST"})
     */
    public function newPin(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['token' => $data['token']]);

        $user->setResetPin($data['new_pin']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'PIN preliminary saved',
                ],
            ],
            200
        );
    }

    /**
     * @Route("/api/auth/finalPin", name="finalPin", methods={"POST"})
     */
    public function finalSavePin(Request $request, ManagerRegistry $doctrine)
    {
        $data = json_decode($request->getContent(), true);

        $repository = $doctrine->getRepository(User::class);

        $matchingCode = $repository->findOneBy(['token' => $data['token']]);

        if ($matchingCode->getResetPin() != $data['confirm_pin']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Введенный код не совпадает с присланным на почтовый ящик',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $matchingCode->setPin($data['confirm_pin']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($matchingCode);
        $em->flush();

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'message' => 'Codes match',
                ],
            ],
            200
        );
    }
}
