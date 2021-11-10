<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\VerificationRequest;
use App\Repository\VerificationRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @IgnoreAnnotation("apiVersion")
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

    private function validateEmail($errorsString, $email){
        $verificationRequest = $this->getDoctrine()->getRepository(VerificationRequest::class)->findValidByEmail($email);
        if(!$verificationRequest){
            $errorsString['email'] = 'Invalid email';
            return $errorsString;
        }
        return $errorsString;
    }

    private function validatePassword($errorsString, $data){
        $length = strlen($data['password']);
        if ($length < 8){
            $errorsString['password'] = 'Must be 8 characters or more';
            return $errorsString;
        }
        if ($length > 32){
            $errorsString['password'] = 'Must be 32 characters or less';
            return $errorsString;
        }
        $pattern = "/^[a-zA-Z0-9!@#$%^&`*()_=+;:'\x22?,<>\[\]{}\\|\/№!~-]+\.?[a-zA-Z0-9!@#$%^&*()_=+;:'\x22?,<>\[\]{}\\|\/№!~-]+$/u";
        if (!preg_match($pattern, $data['password'])){
            $errorsString['password'] = 'Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last';
            return $errorsString;
        }
        if ($data['password'] !== $data['confirmPassword']){
            $errorsString['password'] = 'Password and confirm password don\'t match';
            return $errorsString;
        }
        return $errorsString;
    }

    private function validate($user, $data, $type = 'email')
    {
        $errorsString = [];
        if ($type == 'email') {
            $errorsString =  $this->validateEmail($errorsString, $data['email']);
        }

        $errorsString = $this->validatePassword($errorsString, $data);

        $errors = $this->validator->validate($user, null, ['Default', $type]);

        foreach ($errors as $error) {
            $errorsString[$error->getPropertyPath()] = $error->getMessage();
        }
        return $errorsString;
    }

    /**
     * @api {post} /backend/api/registration/email Email registration
     * @apiVersion 0.0.1
     * @apiName PostApiRegistrationEmail
     * @apiGroup Authentication
     *
     * @apiBody {String} firstName
     * @apiBody {String} lastName
     * @apiBody {String} userName
     * @apiBody {String} email
     * @apiBody {String} password
     * @apiBody {String} confirmPassword
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
     * @apiError (Empty Request) {Boolean} success Should be false
     * @apiError (Empty Request) {JSON} body Error parametrs
     * @apiError (Empty Request) {String} body.message Error message
     * @apiErrorExample {json}  Empty json request 
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *          "message": "Empty input"
     *       }
     *     }
     * 
     * @apiError (Invalid Request) {Boolean} success Should be false
     * @apiError (Invalid Request) {JSON} body Error parametrs
     * @apiError (Invalid Request) {String} body.message Array of errors
     * @apiErrorExample {json} Empty input
     *     HTTP/1.1 400
     *     {
     *       "success": false,
     *       "body": {
     *          "message": {
     *              "password": "Must be 8 characters or more",
     *              "email": "Invalid e-mail Address"
     *              "firstName": "Must be 2 characters or more",
     *              "lastName": "Must be 2 characters or more",
     *              "userName": "Must be 2 characters or more"
     *           }
     *       }
     *     }
     * @apiErrorExample {json} Invalid input
     *     HTTP/1.1 400
     *     {
     *       "success": false,
     *       "body": {
     *           "message": {
     *              "password": "Passsword and confirm password don't match",
     *              "email": "Invalid e-mail Address"
     *              "firstName": "Can contain letters, numbers, !@#$%^&*()_-=+;:'\x22?,<>[]{}\|/№!~' symbols, and one dot not first or last",
     *              "lastName": "Must be 60 characters or less",
     *              "userName": "Must be 60 characters or more"
     *           }
     *       }
     *     }
     * @apiErrorExample {json} Email already used
     *     HTTP/1.1 400
     *     {
     *       "success": false,
     *       "body": {
     *           "message": {
     *               "email": "This value is already used."
     *           }
     *       }
     *     }
     * @apiErrorExample {json} Email wasn't verified
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Invalid email"
     *       }
     *     }
     */
    public function emailRegistration(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
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

        if (!empty($errorsString)) {
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
     * @api {post} /backend/api/registration/phone Phone registration
     * @apiVersion 0.0.1
     * @apiName PostApiRegistrationPhone
     * @apiGroup Authentication
     *
     * @apiBody {String} firstName
     * @apiBody {String} lastName
     * @apiBody {String} userName
     * @apiBody {String} phone
     * @apiBody {String} password
     * @apiBody {String} confirmPassword
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
     * @apiError (Empty Request) {Boolean} success Should be false
     * @apiError (Empty Request) {JSON} body Error parametrs
     * @apiError (Empty Request) {String} body.message Error message
     * @apiErrorExample {json} Empty json request 
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Empty input"
     *       }
     *     }
     * 
     * @apiError (Invalid Request) {Boolean} success Should be false
     * @apiError (Invalid Request) {JSON} body Error parametrs
     * @apiError (Invalid Request) {String} body.message Array of errors
     * @apiErrorExample {json} Empty input
     *     HTTP/1.1 400
     *     {
     *       "success": false,
     *       "body": {
     *          "message": {
     *              "password": "Must be 8 characters or more",
     *              "phone": "Must be 7 characters or more"
     *              "firstName": "Must be 2 characters or more",
     *              "lastName": "Must be 2 characters or more",
     *              "userName": "Must be 2 characters or more"
     *           }
     *       }
     *     }
     * @apiErrorExample {json} Invalid input
     *     HTTP/1.1 400
     *     {
     *       "success": false,
     *       "body": {
     *           "message": {
     *              "password": "Passsword and confirm password don't match",
     *              "phone": "incorrect phone format"
     *              "firstName": "Can contain letters, numbers, !@#$%^&*()_-=+;:'\x22?,<>[]{}\|/№!~' symbols, and one dot not first or last",
     *              "lastName": "Must be 60 characters or less",
     *              "userName": "Must be 60 characters or more"
     *           }
     *       }
     *     }
     * @apiErrorExample {json} Phone already used
     *     HTTP/1.1 400
     *     {
     *       "success": false,
     *       "body": {
     *           "message": {
     *               "phone": "This value is already used."
     *           }
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
