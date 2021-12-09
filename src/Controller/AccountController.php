<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
 * @IgnoreAnnotation("apiParamExample")
 */

class AccountController extends AbstractController
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @api {get} /backend/api/accounts/logged-in-user View
     * @apiName GetApiAccountsView
     * @apiGroup User
     *
     * @apiSuccess (200) {String} success Should show user
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *
     *        {
     *           "id": 1,
     *           "firstName": "firstName",
     *           "lastName": "lastName",
     *           "userName": "userName",
     *        }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parameters
     * @apiError {String} body.message Error message
     * @apiErrorExample {json} Error-Response:
     *  HTTP/1.1 403
     *     {
     *          "success": false,
     *          "body": {
     *              "message": "Access denied"
     *          }
     *      }
     *
     **/
    public function accountApi()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        return $this->json([
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'userName' => $user->getUserName(),
        ]);
    }

    /**
     * @api {get} /backend/api/accounts List
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
     * @api {put} /backend/api/accounts/:id Update
     * @apiName PutApiAccountsUpdate
     * @apiGroup User
     *
     * @apiHeader {String} X-AUTH-TOKEN API-Token.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "X-AUTH-TOKEN": "152133606dc58da26d4d775ae93624c844b6826bdaa9fefa4f05f009500b2f7f5686633434cc6d03de533d06568fc363311579f6e9ef6f18a70277c1"
     *     }
     *
     * @apiParam {Number} id Id of user that we change(part of url)
     * @apiBody {String} [firstName]      Optional firstName of the User.
     * @apiBody {String} [lastName]       Optional lastName of the User.
     * @apiBody {String} [userName]       Optional userName of the User.
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

    /** Validate password
     *
     * @param string $password password
     * @param string $confirm password confirmation
     * @return string|null
     */
    private function validatePassword($password, $confirm): ?string
    {
        $length = mb_strlen($password);
        if ($length < 8) {
            return 'Must be 8 characters or more';
        }
        if ($length > 32) {
            return 'Must be 32 characters or less';
        }
        $pattern = "/^[a-zA-Zа-яА-Я0-9!@#$%^&`*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~]+\.{0,1}[a-zA-Zа-яА-Я0-9!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~]+$/u";
        if (!preg_match($pattern, $password)) {
            return 'Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last';
        }
        if ($password !== $confirm) {
            return 'Password and confirm password don\'t match';
        }
        return null;
    }

    /**
     * @api {post} /backend/api/accounts/change_pass/:id Change password
     * @apiName PostApiAccountsChangePassword
     * @apiGroup User
     *
     * @apiHeader {String} X-AUTH-TOKEN API-Token.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "X-AUTH-TOKEN": "152133606dc58da26d4d775ae93624c844b6826bdaa9fefa4f05f009500b2f7f5686633434cc6d03de533d06568fc363311579f6e9ef6f18a70277c1"
     *     }
     *
     * @apiParam {Number} id Id of user that we change(part of url)
     * @apiBody {String} oldPassword      current user password
     * @apiBody {String} newPassword      new user password
     * @apiBody {String} confirmPassword       confirm new password
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "oldPassword": "oldPassword",
     *       "newPassword": "newPassword",
     *       "confirmPassword": "newPassword"
     *     }
     *
     * @apiSuccess (200) {Boolean} body Response body
     * @apiSuccess (200) {Array} users Should return array of users if exists
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": true,
     *       "body": {}
     *     }
     *
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
     * @apiErrorExample {json} Empty json request
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Empty input"
     *       }
     *     }
     * @apiErrorExample {json} incorrect old password
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Invalid password"
     *       }
     *     }
     * @apiErrorExample {json} password less than 8 characters
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Must be 8 characters or more"
     *       }
     *     }
     * @apiErrorExample {json} password more than 32 characters
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Must be 32 characters or less"
     *       }
     *     }
     * @apiErrorExample {json} password validation
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last"
     *       }
     *     }
     * @apiErrorExample {json} password and confirm password
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Password and confirm password don't match"
     *       }
     *     }
     * @apiErrorExample {json} passwords can't match
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Old password and new password can't match"
     *       }
     *     }
     * @apiErrorExample {json} unreliable password
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "This password has been leaked in a data breach, it must not be used. Please use another password."
     *       }
     *     }
     * 
     **/
    public function changePassword(User $user, Request $request, UserPasswordHasherInterface $encoder): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();

        $currentUser = $this->getUser();
        if ($currentUser->getId() != $user->getId()) {
            $response = [
                'success' => false,
                'body' => ['message' => 'You are not allowed to change this user`s data']
            ];
            return new JsonResponse($response, Response::HTTP_FORBIDDEN);
        }

        $data = json_decode($request->getContent(), true);

        if (!$data) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Empty input']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $verified = $encoder->isPasswordValid($user, $data['oldPassword']);
        if (!$verified) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid password']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $password = isset($data["newPassword"]) ? $data["newPassword"] : "";
        $confirm = isset($data["confirmPassword"]) ? $data["confirmPassword"] : "";
        $errorsString = $this->validatePassword($password, $confirm);
        if (!empty($errorsString)) {
            $response = [
                'success' => false,
                'body' => ['message' => $errorsString]
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        if ($data['oldPassword'] == $password) {
            return new JsonResponse([
                'success' => false,
                'body' => ['message' => 'Old password and new password can\'t match']
            ], Response::HTTP_BAD_REQUEST);
        }

        $constraint = new NotCompromisedPassword();
        $violations = $this->validator->validate($password, $constraint);
        if ($violations->count() > 0) {
            foreach ($violations as $violation) {
                if ($violation instanceof ConstraintViolation) {
                    $message = $violation->getMessage();
                    $message = is_string($message) ? $message : '';
                }
            }
        }

        if (isset($message)) {
            return new JsonResponse([
                'success' => false,
                'body' => ['message' => $message]
            ], Response::HTTP_BAD_REQUEST);
        }
        
        $user->setPassword($encoder->hashPassword(
            $user,
            $password
        ));
        $entityManager->persist($user);
        $entityManager->flush();

        $response = ['success' => true, 'body' => []];
        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * @api {delete} /backend/api/accounts/:id Delete
     * @apiName DeleteApiAccountsDelete
     * @apiGroup User
     *
     * @apiHeader {String} X-AUTH-TOKEN API-Token.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "X-AUTH-TOKEN": "152133606dc58da26d4d775ae93624c844b6826bdaa9fefa4f05f009500b2f7f5686633434cc6d03de533d06568fc363311579f6e9ef6f18a70277c1"
     *     }
     *
     * @apiParam {Number} id Id of user that we change(part of url)
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
