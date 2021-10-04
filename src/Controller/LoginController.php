<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ApiToken;
use App\Repository\ApiTokenRepository;
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
    private function generateTokin($user,$data): Response 
    {
        $entityManager = $this->getDoctrine()->getManager();
        $remember = array_key_exists('rememberMe',$data)?:false;
        $apiToken = new ApiToken($user,$remember);
        $entityManager->persist($apiToken);
        $entityManager->flush();
        $response = ['success' => true,'body' => ['token' => $apiToken->getToken()]];
        return new JsonResponse($response, Response::HTTP_OK); 
    }

    /**
     * @api {post} /api/login/email Email login
     * @apiName PostApiLoginEmail
     * @apiGroup Authentication
     *
     * @apiBody {String} email
     * @apiBody {String} password
     * @apiBody {Boolean} rememberMe
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.token API Token
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": { 
     *           "token":"8b9e16a42e33a25ecbc0e9d7c75127f2"
     *       }
     *     }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parametrs
     * @apiError {String} body.message Error message
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Empty input"
     *       }
     *     }
     * 
     */
    public function emailLogin(Request $request,UserPasswordHasherInterface $encoder): Response
    {
        $data = json_decode($request->getContent(),true);
        if (!$data){
            $response = [
                'success' => false,
                'body' => ['message'=>'empty input']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if(!$user){
            $response = [
                'success' => false,
                'body' => ['message'=>'bad login']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }
        $verified = $encoder->isPasswordValid($user,$data['password']);
        if(!$verified){
            $response = [
                'success' => false,
                'body' => ['message'=>'bad login']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }
        if (!$user->getVerified()){
            $response = [
                'success' => false,
                'body' => ['message'=>'not verified']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }
        return $this->generateTokin($user,$data);
    }

    /**
     * @api {post} /api/login/phone Phone login
     * @apiName PostApiLPhoneEmail
     * @apiGroup Authentication
     *
     * @apiBody {String} phone
     * @apiBody {String} password
     *  @apiBody {Boolean} rememberMe
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.token API Token
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": { 
     *           "token":"8b9e16a42e33a25ecbc0e9d7c75127f2"
     *       }
     *     }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parametrs
     * @apiError {String} body.message Error message
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Empty input"
     *       }
     *     }
     * 
     */
    public function phoneLogin(Request $request,UserPasswordHasherInterface $encoder): Response
    {
        $data = json_decode($request->getContent(),true);
        if (!$data){
            $response = [
                'success' => false,
                'body' => ['message'=>'empty input']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['phone' => $data['phone']]);
        if(!$user){
            $response = [
                'success' => false,
                'body' => ['message'=>'bad login']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }
        $verified = $encoder->isPasswordValid($user,$data['password']);
        if(!$verified){
            $response = [
                'success' => false,
                'body' => ['message'=>'bad login']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }
        return $this->generateTokin($user,$data);
    }

    /**
     * @api {get} /api/logout Logout
     * @apiName GetApiLogout
     * @apiGroup Authentication
     *
     * @apiHeader {String} X-AUTH-TOKEN API-Token.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "X-AUTH-TOKEN": "8b9e16a42e33a25ecbc0e9d7c75127f2"
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
     * @apiErrorExample {json} Error-Response:
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
        $response = ['success' => true,'body' => []];
        return new JsonResponse($response, Response::HTTP_OK); 
    }
}
