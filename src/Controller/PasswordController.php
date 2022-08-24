<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PasswordController extends AbstractController
{
    protected $password;
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/api/auth/password", name="password", methods={"POST"})
     */
    public function passwordMatch(Request $request, ValidatorInterface $validatorPass, UserPasswordHasherInterface $passwordHasher)
    {
        $data = json_decode($request->getContent(), true);

        $session = $this->requestStack->getSession();

        $session->set('password', $data['password']);
        $sesPass = $session->get('password');
        $sesEmail = $session->get('email');

        if ($sesPass !== $data['confirm_password']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Passwords do not match',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($sesEmail !== $data['email']) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Emails do not match',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $user = $session->get('user');

        $errors = $validatorPass->validate($user, null, 'password');

        if (count($errors) > 0) {
            $errorsStringPass = (string) $errors;

            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => $errorsStringPass,
                    ],
                ],
                Response::HTTP_BAD_REQUEST);
        }

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $sesPass
        );

        $session->set('password', $hashedPassword);

        return new JsonResponse(
    [
        'success' => true,
        'body' => [
            'message' => 'Password saved',
        ],
    ],
    200
    );
    }
}
