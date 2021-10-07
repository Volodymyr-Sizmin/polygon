<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IgnoreAnnotation("apiName")
 * @IgnoreAnnotation("apiGroup")
 * @IgnoreAnnotation("apiParam")
 * @IgnoreAnnotation("apiBody")
 * @IgnoreAnnotation("apiSuccess")
 * @IgnoreAnnotation("apiSuccessExample")
 * @IgnoreAnnotation("apiError")
 * @IgnoreAnnotation("apiErrorExample")
 * @IgnoreAnnotation("apiHeader")
 * @IgnoreAnnotation("apiHeaderExample")
 */
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

    /**
     * @api {get} /api/accounts/list List
     * @apiName GetApiAccountsList
     * @apiGroup User
     *
     * @apiSuccess (200) {String} success Should show list of users
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": true,
     *       "users": [
     *        {
     *           "id": 1,
     *           "userName": "Username"
     *        }
     *      ]
     *     }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parameters
     * @apiError {String} body.message Error message
     * @apiErrorExample {json} Error-Response:
     *  HTTP/1.1 401
     *     {
     *          "success": false,
     *          "body": {
     *              "message": "Unauthorized access"
     *          }
     *      }
     *
     * @Route("/api/accounts/list", methods={"GET"})
     **/
    public function list()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $usersPrepared = [];

        /* @var $user User[] */
        foreach ($users as $user) {
            array_push($usersPrepared, $user->getPublicData());
        }
        $response = [
            'success' => true,
            'users' => $usersPrepared
        ];

        return new JsonResponse($response);
    }

    /**
     * @api {put} /api/accounts Update
     * @apiName PutApiAccountsUpdate
     * @apiGroup User
     *
     * @apiParam {String} [firstName]      Optional firstName of the User.
     * @apiParam {String} [lastName]       Optional lastName of the User.
     * @apiParam {String} [userName]       Optional userName of the User.
     *
     * @apiSuccess (200) {Boolean} success true
     * @apiSuccess (200) {Array} users Should return array of users if exists
     * @apiParamExample {json} Request-Example:
     *     {
     *       "firstName": "firstName",
     *       "lastName": "lastName",
     *       "userName": "userName"
     *     }
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": true,
     *       "user": [
     *        {
     *            "firstName": "firstName",
     *            "lastName": "lastName",
     *            "userName": "userName"
     *        }
     *      ]
     *     }
     * @apiError {Boolean} success false
     * @apiError {JSON} body Error parameters
     * @apiError {String} body.message Error message
     * @apiErrorExample {json} Error-Response:
     *  HTTP/1.1 403
     *     {
     *          "success": false,
     *          "body": {
     *              "message": "You are not allowed to change this user`s data"
     *          }
     *      }
     *
     * @Route("/api/accounts", methods={"PUT"})
     **/
    public function update(User $user, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();

        $currentUser = $this->getUser();
        if ($currentUser->getId() != $user->getId()) {
            new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'You are not allowed to change this user`s data'
                    ]
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        $data = json_decode($request->getContent(), true);

        $user->setFirstName(isset($data["firstName"]) ? $data["firstName"] : $user->getFirstName());
        $user->setLastName(isset($data["lastName"]) ? $data["lastName"] : $user->getLastName());
        $user->setUserName(isset($data["userName"]) ? $data["userName"] : $user->getUsername());

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'user' => [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'userName' => $user->getUserName(),
        ]]);
    }

    /**
     * @api {delete} /api/accounts Delete
     * @apiName DeleteApiAccountsDelete
     * @apiGroup User
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 204 No Content
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parameters
     * @apiError {String} body.message Error message
     * @apiErrorExample {json} Error-Response:
     *  HTTP/1.1 403
     *     {
     *          "success": false,
     *          "body": {
     *               "message": "You are not allowed to delete this user`s data"
     *          }
     *      }
     *
     * @Route("/api/accounts", methods={"DELETE"})
     **/
    public function delete(User $user): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();
        $currentUser = $this->getUser();
        if ($currentUser->getId() != $user->getId()) {
            $response = [
                'success' => false,
                'body' => ['message' => 'You are not allowed to delete this user`s data']
            ];
            return new JsonResponse($response, Response::HTTP_FORBIDDEN);
        }

        $user->setIsDeleted(true);

        $entityManager->merge($user);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
