<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NonClientRegisterController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/api/auth/nonclient", name="nonclient", methods={"POST"})
     */
    public function nonClientRegister(Request $request, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);

        $session = $this->requestStack->getSession();

        $session->set('firstName', $data['FirstName']);
        $session->set('lastName', $data['LastName']);
        $session->set('passId', $data['PassId']);

        $em = $this->getDoctrine()->getManager();
        $userId = $em->getRepository(User::class)->findBy(['passport_id' => $data['PassId']]);

        if (!empty($userId)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Hello. A user with this Id has already been registered in the system. Please call the number +7 XXX XXXX XXXX or contact the nearest bank office.',
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $user = $session->get('user');
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

        $response = ['success' => true, 'body' => [
            'message' => [
                'Ok',
                ],
            ],
        ];

        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
