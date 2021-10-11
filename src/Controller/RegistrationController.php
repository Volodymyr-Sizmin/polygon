<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
 */
class RegistrationController extends AbstractController
{
    private $validator;
    private $encoder;

    public function __construct(ValidatorInterface $validator, UserPasswordHasherInterface $encoder)
    {
        $this->validator = $validator;
        $this->encoder = $encoder;
    }

    private function validate($user, $data, $type = 'email')
    {
        $errorsString =  [];
        if ($data['password'] !== $data['confirmPassword']){
            $errorsString['password'] = 'passsword and confirm password don\'t match';
        }
        $errors = $this->validator->validate($user, null, ['Default', $type]);
        foreach($errors as $error){
            $errorsString[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errorsString;
    }

    /**
     * @api {post} /api/registration/email Email registarion
     * @apiName PostApiRegistationEmail
     * @apiGroup Authentication
     *
     * @apiBody {String} firstName
     * @apiBody {String} lastName
     * @apiBody {String} userName
     * @apiBody {String} email
     * @apiBody {String} password
     * @apiBody {String} confirmPasswords
     *
     * @apiSuccess (201) {Boolean} success Should be true
     * @apiSuccess (201) {JSON} body Response body
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 CREATED
     *     {
     *       "success": "true",
     *       "body": {}
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
    public function emailRegistration(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data){
            $response = [
                'success' => false,
                'body' => ['message'=>'Empty input']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }

        $entetyManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setUserName($data['userName']);
        $user->setEmail($data['email']);
        $errorsString = $this->validate($user, $data, 'email');
        if (!empty($errorsString)){
            $response = [
                'success' => false,
                'body' => ['message'=>$errorsString ]
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }

        $user->setPassword($this->encoder->hashPassword(
            $user,
            $data['password']
        ));

        $entetyManager->persist($user);
        $entetyManager->flush();
        $response = ['success' => true, 'body' => []];
        return new JsonResponse($response, Response::HTTP_CREATED); 
    }

    /**
     * @api {post} /api/registration/phone Phone registarion
     * @apiName PostApiRegistationPhone
     * @apiGroup Authentication
     *
     * @apiBody {String} firstName
     * @apiBody {String} lastName
     * @apiBody {String} userName
     * @apiBody {String} phone
     * @apiBody {String} password
     * @apiBody {String} confirmPasswords
     *
     * @apiSuccess (201) {Boolean} success Should be true
     * @apiSuccess (201) {JSON} body Response body
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 CREATED
     *     {
     *       "success": "true",
     *       "body": {}
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

    public function phoneRegistration(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data){
            $response = [
                'success' => false,
                'body' => ['message'=>'Empty input']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }

        $entetyManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setUserName($data['userName']);
        $user->setPhone($data['phone']);
        $errorsString = $this->validate($user, $data, 'phone');
        if (!empty($errorsString)){
            $response = [
                'success' => false,
                'body' => ['message'=>$errorsString ]
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }

        $user->setPassword($this->encoder->hashPassword(
            $user,
            $data['password']
        ));

        $entetyManager->persist($user);
        $entetyManager->flush();
        $response = ['success' => true, 'body' => []];
        return new JsonResponse($response, Response::HTTP_CREATED); 
    }
}
