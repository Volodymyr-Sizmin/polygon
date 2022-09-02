<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
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
    public function nonClientRegister(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator, Response $response)
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['email']) && $data ['FirstName'] && $data['LastName'] && $data['PassId']) {
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

        $em = $this->getDoctrine()->getManager();
        $userId = $em->getRepository(User::class)->findBy(['passport_id' => $data['PassId']]);

        if (!empty($userId)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Hello. A user with this Id has already been registered in the system. Please call the number +7 XXX XXXX XXXX or contact the nearest bank office.',
                        'cookie' => $response
                    ],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $userEmail = $em->getRepository(User::class)->findOneBy(['email' => $data['email']]);

//        if (!empty($userEmail)) {
//            return new JsonResponse(
//                [
//                    'success' => false,
//                    'body' => [
//                        'message' => 'Hello. A user with this email has already been registered in the system. Please call the number +7 XXX XXXX XXXX or contact the nearest bank office.',
//                    ],
//                ],
//                Response::HTTP_BAD_REQUEST
//            );
//        }

        $user = new User();
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

        $userEmail->setFirstName($data['FirstName']);
        $userEmail->setLastName($data['LastName']);
        $userEmail->setPassportId($data['PassId']);
        $userEmail->setCounter(5);

        $em->persist($userEmail);
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
