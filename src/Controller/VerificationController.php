<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\VerificationRequest;
use App\Service\VerificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

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
    private $verificationService;

    public function __construct(EntityManagerInterface $entityManager, VerificationService $verificationService)
    {
        $this->entityManager = $entityManager;
        $this->verificationService = $verificationService;
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
    public function emailVerification(Request $request): JsonResponse
    {
        $data = [
            'email' => $request->get('email')
        ];

        if (empty($data['email'])) {
            return new JsonResponse (
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Empty input'
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            ); 
        }
        $verificationRequest = new VerificationRequest($data['email']);
        $errorsString = $this->verificationService->validate($verificationRequest);

        if (!empty($errorsString)) {
            return new JsonResponse (
                [
                    'success' => false,
                    'body' => [
                        'message' => $errorsString
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );  
        }

        $url = 'http://localhost:1100/backend/verify/email/';
        $error = $this->verificationService->sendEmail($verificationRequest, $url);
        if ($error) {
            return new JsonResponse (
                [
                    'success' => false,
                    'body' => [
                        'message' => $error->getMessage()
                    ]
                ],
                Response::HTTP_FAILED_DEPENDENCY
            );   
        }

        $this->entityManager->persist($verificationRequest);
        $this->entityManager->flush();

        return new JsonResponse (
            [
                'success' => true,
                'body' => [
                    'url' => $verificationRequest->getUrl()
                ]
            ],
            Response::HTTP_CREATED
        ); 
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
     * @apiSuccess (200) {String} body.email Email that was connected to this verification request
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
     *           "message": "Not found"
     *       }
     *     }
     * @apiErrorExample {json} Request expired:
     *     HTTP/1.1 410
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "Expired"
     *       }
     *     }
     * 
     */
    public function verifyEmail(string $url): JsonResponse
    {
        $verificationRequest = $this->getDoctrine()->getRepository(VerificationRequest::class)->findOneBy(['url' => $url]);
        if (!$verificationRequest) {
            return new JsonResponse (
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Not found'
                    ]
                ],
                Response::HTTP_NOT_FOUND
            );
        }
        if ($verificationRequest->checkExpired()) {
            $this->entityManager->remove($verificationRequest);
            $this->entityManager->flush();
            return new JsonResponse (
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Expired'
                    ]
                ],
                Response::HTTP_GONE
            );
        }

        $verificationRequest->setVerified(true);
        $this->entityManager->persist($verificationRequest);
        $this->entityManager->flush();

        return new JsonResponse (
            [
                'success' => true,
                'body' => [
                    'email' => $verificationRequest->getEmail()
                ]
            ],
            Response::HTTP_OK
        );
    }
}
