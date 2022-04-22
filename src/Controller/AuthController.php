<?php

namespace App\Controller;

use App\Entity\BankUser;
use App\Entity\VerificationRequest;
use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AuthController extends AbstractController
{
    private $encoder;

    public function __construct(ValidatorInterface $validator, UserPasswordHasherInterface $encoder)
    {
        $this->validator = $validator;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/api/auth/register", name="register", methods={"POST"})
     */
    public function register(Request $request, ValidatorInterface $validator)
    {

        $data = json_decode($request->getContent(), true);

        $data['password'] = $request->get('password');
        $data['phone'] = $request->get('phone');

        $user = new BankUser();

        $user->setPassword($data['password']);
        $user->setPhone($data['phone']);
        dd($request);
        if (!isset($data['phone'])) {
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

        $errors = $validator->validate($user);

        if (count($errors) > 0) {

            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        $user->setPassword($this->encoder->hashPassword(
            $user,
            $data['password']
        ));
        //$encoder->hashPassword($user, $data['password']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $response = ['success' => true, 'body' => []];


        return new JsonResponse($response, Response::HTTP_CREATED);

    }
}
