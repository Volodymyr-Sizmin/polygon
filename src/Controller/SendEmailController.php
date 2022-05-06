<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Firebase\JWT\JWT;
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
    /**
     * @Route("/api/auth/sendemail", name="email", methods={"POST"})
     */
    public function sendEmail(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $data= json_decode($request->getContent(), true);

        //$data['email'] = $request->get('email');
//        dd($user)

        if (empty($data['email']))
        {
            return new JsonResponse (
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Empty input'
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        //dd($doctrine->getRepository(User::class)->find($data['email']));
//        if (($data['email']) == $doctrine->getRepository(User::class)->find($data['email']))
//        {
//            return new JsonResponse (
//                [
//                    'success' => false,
//                    'body' => [
//                        'message' => 'Your email has already been used'
//                    ]
//                ],
//                Response::HTTP_BAD_REQUEST
//            );
//        }
        $data['code'] = rand(100000, 999999);

        $token = JWT::encode($data, '%env(resolve:JWT_SECRET)%', 'HS256');

        $user = new User();

        $user->setEmail($data['email']);
        $user->setCode($data['code']);
        $user->setToken($token);

        $errors = $validator->validate($user, null, 'registration');

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new JsonResponse (
                [
                    'success' => false,
                    'body' => [
                        'message' => $errorsString
                    ]
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
                'token' => $token
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
