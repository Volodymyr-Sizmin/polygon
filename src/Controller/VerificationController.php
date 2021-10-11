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
class VerificationController extends AbstractController
{
    private function deleteRequest(VerificationRequest $verificationRequest)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($verificationRequest);
        $entityManager->flush();
    }

    private function verifyUser(VerificationRequest $verificationRequest)
    {
        $user = $verificationRequest->getUser();
        $user->setVerified(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
    }

    private function sendEmail(VerificationRequest $verificationRequest, MailerInterface $mailer)
    {
        $url = 'http://localhost:1100/backend/verify/email/';
        $url .= $verificationRequest->getUrl();
        $to = $verificationRequest->getUser()->getEmail();
        $email = (new Email())
            ->from('poligon@mail.com')
            ->to($to)
            ->subject('Verify POLIGON account')
            ->text("To activate your account go to this url: $url")
            ->html("<p>Click url to activate account</p><a href='$url'>$url</a>");

        $mailer->send($email);
    }

    /**
     * @api {post} /api/verify/email/send Send verification email
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
    public function emailVerification(Request $request, MailerInterface $mailer): Response
    {
        $data = json_decode($request->getContent(), true);
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
                'body' => ['message'=>'bad email']
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST); 
        }

        if($user->getVerified()){
            $response = ['success' => true, 'body' => ['message' => 'already verified']];
            return new JsonResponse($response, Response::HTTP_OK); 
        }

        $entityManager = $this->getDoctrine()->getManager();
        $verificationRequest = new VerificationRequest($user);
        $this->sendEmail($verificationRequest, $mailer);
        $entityManager->persist($verificationRequest);
        $entityManager->flush();
        $response = ['success' => true, 'body' => ['url' => $verificationRequest->getUrl()]];
        return new JsonResponse($response, Response::HTTP_CREATED); 
    }

    /**
     * @api {GET} /verify/email/:url Verification url
     * @apiName GetVerificationUrl
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
        $this->verifyUser($verificationRequest);
        $this->deleteRequest($verificationRequest);
        $response = ['success' => true, 'body' => []];
        return new JsonResponse($response, Response::HTTP_OK); 
    }
}
