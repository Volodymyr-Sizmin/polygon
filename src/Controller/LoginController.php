<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ApiToken;
use App\Repository\ApiTokenRepository;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
class LoginController extends AbstractController
{
    private function generateToken($user, $data): string
    {
        $entityManager = $this->getDoctrine()->getManager();
        $remember = array_key_exists('rememberMe', $data) ?: false;
        $apiToken = new ApiToken($user, $remember);
        $entityManager->persist($apiToken);
        $entityManager->flush();
        return $apiToken->getToken();
    }

    /**
     * @api {post} /backend/api/login/email Email login
     * @apiName PostApiLoginEmail
     * @apiGroup Authentication
     *
     * @apiBody {String} email
     * @apiBody {String} password
     * @apiBody {Boolean} rememberMe
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.user_id User ID
     * @apiSuccess (200) {String} body.token API Token
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": {
     *           "user_id": 1,
     *           "token":"8b9e16a42e33a25ecbc0e9d7c75127f2"
     *       }
     *     }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parametrs
     * @apiError {String} body.message Error message
     * @apiErrorExample {json}  Empty json request
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Empty input"
     *       }
     *     }
     * @apiErrorExample {json} User doesn't exist
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Invalid login"
     *       }
     *     }
     * @apiErrorExample {json} Incorrect password
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Invalid login"
     *       }
     *     }
     */
    public function emailLogin(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Empty input']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if (!$user) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $verified = $encoder->isPasswordValid($user, $data['password']);
        if (!$verified) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'success' => true,
            'body' => [
                'user_id' => $user->getId(),
                'token' => $this->generateToken($user, $data)
            ]
        ]);
    }

    /**
     * @api {post} /backend/api/login/phone Phone login
     * @apiName PostApiLPhoneEmail
     * @apiGroup Authentication
     *
     * @apiBody {String} phone
     * @apiBody {String} password
     * @apiBody {Boolean} rememberMe
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.user_id User ID
     * @apiSuccess (200) {String} body.token API Token
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": {
     *           "user_id": 1,
     *           "token":"8b9e16a42e33a25ecbc0e9d7c75127f2"
     *       }
     *     }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parametrs
     * @apiError {String} body.message Error message
     * @apiErrorExample {json}  Empty json request
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Empty input"
     *       }
     *     }
     * @apiErrorExample {json} User doesn't exist
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Invalid login"
     *       }
     *     }
     * @apiErrorExample {json} Incorrect password
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Invalid login"
     *       }
     *     }
     * @apiErrorExample {json} User wasn't verified
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Invalid verified"
     *       }
     *     }
     *
     */
    public function phoneLogin(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Empty input']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['phone' => $data['phone']]);
        if (!$user) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $verified = $encoder->isPasswordValid($user, $data['password']);
        if (!$verified) {
            $response = [
                'success' => false,
                'body' => ['message' => 'Invalid login']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'success' => true,
            'body' => [
                'user_id' => $user->getId(),
                'token' => $this->generateToken($user, $data)
            ]
        ]);
    }

    /**
     * @api {get} /backend/api/logout Logout
     * @apiName GetApiLogout
     * @apiGroup Authentication
     *
     * @apiHeader {String} X-AUTH-TOKEN API-Token.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "X-AUTH-TOKEN": "152133606dc58da26d4d775ae93624c844b6826bdaa9fefa4f05f009500b2f7f5686633434cc6d03de533d06568fc363311579f6e9ef6f18a70277c1"
     *     }
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": {}
     *     }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parametrs
     * @apiError {String} body.message Error message
     * @apiErrorExample {json} Not loged in
     *     HTTP/1.1 401
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Not privileged to request the resource."
     *       }
     *     }
     *
     */
    public function logout(Request $request, ApiTokenRepository $apiTokenRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $token = $request->headers->get('X-AUTH-TOKEN');
        $apiToken = $apiTokenRepo->findOneBy(['token' => $token]);
        $user->removeApiToken($apiToken);
        $entityManager->remove($apiToken);
        $entityManager->flush();
        $response = ['success' => true, 'body' => []];
        return new JsonResponse($response, Response::HTTP_OK);
    }
}
