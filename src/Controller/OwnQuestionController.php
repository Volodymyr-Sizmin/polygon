<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OwnQuestionController extends AbstractController
{
    /**
     * @Route("/api/auth/quest", name="question", methods={"POST"})
     */
    public function yourQuestion(Request $request, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);

        $data['token'] = $request->get('token');
        $data['question'] = $request->get('question');
        $data['answer'] = $request->get('answer');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['token' => $data['token']]);

        $user->setQuestion($data['question']);
        $user->setAnswer($data['answer']);

        $errors = $validator->validate($user, null, ['quest']);

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
        $response = ['success' => true, 'body' => ['Ok']];

        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
