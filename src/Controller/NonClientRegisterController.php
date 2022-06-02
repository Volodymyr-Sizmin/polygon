<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NonClientRegisterController extends AbstractController
{
    /**
     * @Route("/api/auth/nonclient", name="nonclient", methods={"POST"})
     */
    public function nonClientRegister(Request $request, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['token' => $data['token']]);

        $user->setFirstName($data['FirstName']);
        $user->setLastName($data['LastName']);
        $user->setPassportId($data['PassId']);

        $errors = $validator->validate($user, null, ['name', 'passport']);

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

        $em->persist($user);
        $em->flush();
        $response = ['success' => true, 'body' => [
            'message' => [
                'Ok',
                ],
            ],
        ];

        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
