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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
class VerificationController extends AbstractController
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    private function deleteRequest(VerificationRequest $verificationRequest)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($verificationRequest);
        $entityManager->flush();
    }

    private function sendEmail(VerificationRequest $verificationRequest, MailerInterface $mailer)
    {
        $url = 'http://localhost:1100/verify/email/';
        $url .= $verificationRequest->getUrl();
        $to = $verificationRequest->getEmail();
        $email = (new Email())
            ->from('poligon@mail.com')
            ->to($to)
            ->subject('Verify POLIGON account')
            ->text("To activate your account go to this url: $url")
            ->html("<p>Click url to activate account</p><a href='$url'>$url</a>");

        try {
            $mailer->send($email);
        } catch (\Exception $e) {
            return $e;
        }
    }

    private function validate(VerificationRequest $verificationRequest)
    {
        $errorsString = [];
        $errors = $this->validator->validate($verificationRequest);
        foreach($errors as $error){
            $errorsString[$error->getPropertyPath()] = $error->getMessage();
        }
        return $errorsString;
    }

    /**
     * @api {post} /backend/api/verify/email/send Send verification email
     * @apiName PostApiSendVerificationEmail
     * @apiGroup Authentication
     *
     * @apiBody {String} email
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.url used to create verification url
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": { 
     *           "url":"525a4dc0a3a5c198bbc05a61d3b25979"
     *       }
     *     }
     * @apiSuccessExample {json} Email already verified:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": { 
     *           "message":"already verified"
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
     * @apiErrorExample {json} SMTP error 
     *     HTTP/1.1 424
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Connection could not be established with host"
     *       }
     *     }
     */
    public function emailVerification(Request $request, MailerInterface $mailer): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !$data['email']){
            $response = [
                'success' => false,
                'body' => ['message'=>'empty input']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }
        $verificationRequest = new VerificationRequest($data['email']);
        $errorsString = $this->validate($verificationRequest);
        if (!empty($errorsString)){
            $response = [
                'success' => false,
                'body' => ['message'=>$errorsString ]
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }

        $error = $this->sendEmail($verificationRequest, $mailer);
        if ($error){
            $response = [
                'success' => false,
                'body' => ['message'=>$error->getMessage()]
            ];
            return new JsonResponse($response, Response::HTTP_FAILED_DEPENDENCY); 
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($verificationRequest);
        $entityManager->flush();
        $response = ['success' => true, 'body' => ['url' => $verificationRequest->getUrl()]];
        return new JsonResponse($response, Response::HTTP_CREATED); 
    }

    /**
     * @api {GET} /backend/verify/email/:url Email verification url
     * @apiVersion 0.0.1
     * @apiName GetVerificationUrl
     * @apiGroup Authentication
     *
     * @apiParam {String} url request token(part of url)
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess {String} body.email Email that was connected to this verification request
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": { 
     *           "email": "b.astapau@andersenlab.com"
     *       }
     *     }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parametrs
     * @apiError {String} body.message Error message
     * @apiErrorExample {json} Url doesn't exist:
     *     HTTP/1.1 404
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "not found"
     *       }
     *     }
     * @apiErrorExample {json} Request expired:
     *     HTTP/1.1 410
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "expired"
     *       }
     *     }
     * 
     */
    public function verifyEmail(string $url): Response
    {
        $verificationRequest = $this->getDoctrine()->getRepository(VerificationRequest::class)->findOneBy(['url' => $url]);
        if(!$verificationRequest){
            $response = [
                'success' => false,
                'body' => ['message'=>'not found']
            ];
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }
        if($verificationRequest->checkExpired()){
            $this->deleteRequest($verificationRequest);
            $response = [
                'success' => false,
                'body' => ['message'=>'expired']
            ];
            return new JsonResponse($response, Response::HTTP_GONE);//410
        }
        $verificationRequest->setVerified(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($verificationRequest);
        $entityManager->flush();
        $response = ['success' => true, 'body' => ['email' => $verificationRequest->getEmail()]];
        return new JsonResponse($response, Response::HTTP_OK); 
    }
}
