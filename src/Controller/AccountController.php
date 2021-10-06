<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends AbstractController
{
    public function accountApi()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        return $this->json([
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'userName' => $user->getUserName(),
        ]);
    }

    public function list()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $usersPrepared = [];
        /* @var $user User */
        foreach ($users as $user) {
            array_push($usersPrepared, $user->getPublicData());
        }
        $response = [
            'success' => true,
            'users' => $usersPrepared
        ];

        return new JsonResponse($response);
    }

    public function update(User $user, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $this->denyAccessUnlessGranted('ROLE_USER');

        $currentUser = $this->getUser();
        if ($currentUser->getId() != $user->getId()) {
            $response = [
                'success' => false,
                'body' => ['message' => 'you are not allowed to change this user`s data']
            ];
            return new JsonResponse($response, Response::HTTP_FORBIDDEN);
        }

        $data = json_decode($request->getContent(), true);

        $user->setFirstName(isset($data["firstName"]) ? $data["firstName"] : $user->getFirstName());
        $user->setLastName(isset($data["lastName"]) ? $data["lastName"] : $user->getLastName());
        $user->setUserName(isset($data["userName"]) ? $data["userName"] : $user->getUsername());

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['success' => true, 'body' => 'Account successfully updated']);
    }

    public function delete(User $user, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $this->denyAccessUnlessGranted('ROLE_USER');

        $currentUser = $this->getUser();
        if ($currentUser->getId() != $user->getId()) {
            $response = [
                'success' => false,
                'body' => ['message' => 'you are not allowed to change this user`s data']
            ];
            return new JsonResponse($response, Response::HTTP_FORBIDDEN);
        }

        $user->setIsDeleted(true);

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['success' => true, 'body' => 'Account successfully deleted']);
    }
}
