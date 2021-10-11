<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ResetRequest;
use App\Repository\ResetRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
class ResetController extends AbstractController
{
    private function deleteRequest(ResetRequest $resetRequest)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($resetRequest);
        $entityManager->flush();
    }

    private function activateRequest(ResetRequest $resetRequest)
    {
        $resetRequest->setActivated(true);
        $resetRequest->setExpiresAt(new \DateTime('+1 hour'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($resetRequest);
        $entityManager->flush();
    }

    private function sendEmail(ResetRequest $resetRequest, MailerInterface $mailer)
    {
        $url = 'http://localhost:1100/backend/reset/email/';
        $url .= $resetRequest->getUrl();
        $to = $resetRequest->getUser()->getEmail();
        $email = (new Email())
            ->from('poligon@mail.com')
            ->to($to)
            ->subject('Reset POLIGON account password')
            ->text("If you want to reset password go to this url: $url")
            ->html("<p>Click url if you want to reset password</p><a href='$url'>$url</a>");

        $mailer->send($email);
    }

    /**
     * @api {post} /api/reset/email/send Send email to reset password
     * @apiName PostApiResetEmailSend
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
    public function emailRequestCreation(Request $request, MailerInterface $mailer): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data){
            $response = [
                'success' => false,
                'body' => ['message'=>'empty input']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }

        $user = $this->getDoctrine()->getRepository(User::class)
        ->findOneBy(['email' => $data['email']]);
        if(!$user){
            $response = [
                'success' => false,
                'body' => ['message'=>'bad email']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }

        $entityManager = $this->getDoctrine()->getManager();
        $resetRequest = new ResetRequest($user);
        $this->sendEmail($resetRequest, $mailer);
        $entityManager->persist($resetRequest);
        $entityManager->flush();
        $response = ['success' => true, 'body' => ['url' => $resetRequest->getUrl()]];
        return new JsonResponse($response, Response::HTTP_CREATED); 
    }

    /**
     * @api {GET} /reset/email/:url Reset Email Activation
     * @apiName GetResetEmailActivation
     * @apiGroup Authentication
     *
     * @apiParam {String} url request identifier
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
     *     HTTP/1.1 410
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "expired"
     *       }
     *     }
     * 
     */
    public function activateResetEmail(string $url): Response
    {
        $resetRequest = $this->getDoctrine()->getRepository(ResetRequest::class)
        ->findOneBy(['url' => $url]);
        if(!$resetRequest){
            $response = [
                'success' => false,
                'body' => ['message'=>'not found']
            ];
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }
        if($resetRequest->checkExpired()){
            $this->deleteRequest($resetRequest);
            $response = [
                'success' => false,
                'body' => ['message'=>'expired']
            ];
            return new JsonResponse($response, Response::HTTP_GONE);//410
        }
        $this->activateRequest($resetRequest);
        $response = ['success' => true, 'body' => []];
        return new JsonResponse($response, Response::HTTP_OK); 
    }

    /**
     * @api {post} /api/reset/email/update Update user(email) password
     * @apiName PostApiResetEmailUpdate
     * @apiGroup Authentication
     *
     * @apiBody {String} email
     * @apiBody {String} password
     * @apiBody {String} confirmPasswords
     * 
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.url used to create verification url
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
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Empty input"
     *       }
     *     }
     * 
     */
    public function resetPasswordEmail(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data){
            $response = [
                'success' => false,
                'body' => ['message'=>'Empty input']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }

        $entityManager = $this->getDoctrine()->getManager();
        
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        $resetRequest = $entityManager->getRepository(ResetRequest::class)->findOneBy(['user' => $user]);

        if ($data['password'] !== $data['confirmPassword']){
            $response = [
                'success' => false,
                'body' => ['message'=>'passsword and confirm password don\'t match']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }
        if(!$resetRequest){
            $response = [
                'success' => false,
                'body' => ['message'=>'not found']
            ];
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }
        if($resetRequest->checkExpired()){
            $this->deleteRequest($resetRequest);
            $response = [
                'success' => false,
                'body' => ['message'=>'expired']
            ];
            return new JsonResponse($response, Response::HTTP_GONE);//410
        }
        if(!$resetRequest->getActivated()){
            $response = [
                'success' => false,
                'body' => ['message'=>'needs to be activated']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $user->setPassword($encoder->hashPassword(
            $user,
            $data['password']
        ));

        $this->deleteRequest($resetRequest);
        $entityManager->persist($user);
        $entityManager->flush();
        $response = ['success' => true, 'body' => []];
        return new JsonResponse($response, Response::HTTP_OK); 
    }
}
