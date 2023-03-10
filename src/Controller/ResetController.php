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
use OpenApi\Annotations as OA;

class ResetController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/reset", name="reset", methods={"POST"})
     * @OA\Post(
     *     path="/registration_service/reset",
     *     description="Reset password:send verification code",
     *     tags={"Registration Service"},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *        required={"passport_id"},
     *        @OA\Property(property="passport_id", type="string", example="1234567890")
     *        )
     *      ),
     * @OA\Response(
     *     response=201,
     *     description="Successfully operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="body", type="object",
     *         @OA\Property(property="message", type="string", example="Email has come")
     *       ),
     *       @OA\Property(property="token", type="string", example="Bearer XYZ123")
     *     )
     * ),
     * @OA\Response(
     *     response=400,
     *     description="Bad request",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=false),
     *       @OA\Property(property="body", type="object",
     *         @OA\Property(property="message", type="string", example="Empty input")
     *        )
     *      )
     *     )
     *   )
     */
    public function resetById(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $session = $request->getSession();
        $attempts = $session->get('attempts', ['attempts' => 2, 'email' => 'null']);
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

        if (!$user) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login'],
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $dataArray = [
            'code' => $data['reset_code'],
        ];

        $dataEmail = ['email' => $user->getEmail()];

        $token = $this->tokenService->createToken($dataEmail, $dataArray);

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

        if ($attempts['attempts'] == 0 && $attempts['email'] == $dataEmail['email']) {
            return new JsonResponse(
                [
                    'success' => true,
                    'message' => "0",
                ],
                Response::HTTP_OK
            );
        }

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

        $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
        $mailer = new Mailer($transport);
        $mailer->send($emailForSend);
        $response = [
            'success' => true, 
            'body' => ['message' => 'Email has come'],
            'token' => "Bearer $token",
        ];

        header("Authorization: Bearer $token");
        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
