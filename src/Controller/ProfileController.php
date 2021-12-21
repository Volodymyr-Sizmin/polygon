<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\User;
use App\Service\FileUploader;
use App\Service\ProfileService;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

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
class ProfileController extends AbstractController
{
    private $entityManager;
    private $security;
    private $profileService;

    public function __construct(EntityManagerInterface $entityManager, Security $security, ProfileService $profileService)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->profileService = $profileService;
    }

    /**
     * @api {post} /backend/api/profile/about/photo Upload Profile Photo
     * @apiName PostApiUploadProfilePhoto
     * @apiGroup Profile
     *
     * @apiBody {File} photo
     *
     * @apiSuccess (201) {Boolean} success Should be true
     * @apiSuccess (201) {JSON} body Response body
     * @apiSuccess (201) {String} body.message Success message
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 OK
     *     {
     *       "success": "true",
     *       "body": {
     *           "message":"Profile photo was successfully uploaded."
     *       }
     *     }
     *
     * @apiError (400) {Boolean} success Should be false
     * @apiError (400) {JSON} body Error parameters
     * @apiError (400) {String} body.message Error message
     * @apiErrorExample {json}  Error-Response:
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "No file provided."
     *       }
     *     }
     */
    public function uploadProfilePhoto(Request $request, FileUploader $fileUploader): Response
    {
        $profilePhoto = $request->files->get('photo');

        $validateProfilePhoto = $this->profileService->validateProfilePhoto($profilePhoto);
        if (isset($validateProfilePhoto['error'])) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'message' => $validateProfilePhoto['error'],
                ],
            ], Response::HTTP_CONFLICT);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);

        $uploadProfilePhoto = $this->profileService->uploadProfilePhoto($user, $profilePhoto);
        if (isset($uploadProfilePhoto['error'])) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'message' => $uploadProfilePhoto['error'],
                ],
            ], Response::HTTP_CONFLICT);
        }

        return new JsonResponse([
            'success' => true,
            'body' => [
                'message' => 'Profile photo was successfully uploaded.',
            ],
        ], 201);
    }

    /**
     * @api {get} /backend/api/profile/about/photo Get Profile Photo
     * @apiName GetApiProfilePhoto
     * @apiGroup Profile
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.url Profile photo url
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": {
     *           "url":"http://10.10.15.183:1100/uploads/image/343d9040a671c45832ee5381860e2996-61a4a3e362ca3.png"
     *       }
     *     }
     * @apiError (404) {Boolean} success Should be false
     * @apiError (404) {JSON} body Error parameters
     * @apiError (404) {String} body.message Error message
     * @apiErrorExample {json}  Error-Response:
     *     HTTP/1.1 404
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "No profile photo set."
     *       }
     *     }
     */
    public function getProfilePhoto(Request $request): JsonResponse
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);

        /** @var File $profilePhoto */
        $profilePhoto = $this->profileService->getProfilePhoto($user);
        if (is_array($profilePhoto)) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'message' => $profilePhoto['error'],
                ],
            ], 404);
        }

        return new JsonResponse([
            'success' => true,
            'body' => [
                'url' => $profilePhoto->getUrl(),
            ],
        ]);
    }

    /**
     * @api {delete} /backend/api/profile/about/photo Delete Profile Photo
     * @apiName DeleteApiProfilePhoto
     * @apiGroup Profile
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.url Profile photo url
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": {
     *           "url":"image/343d9040a671c45832ee5381860e2996-61a4a3e362ca3.png"
     *       }
     *     }
     * @apiError (404) {Boolean} success Should be false
     * @apiError (404) {JSON} body Error parameters
     * @apiError (404) {String} body.message Error message
     * @apiErrorExample {json}  Error-Response:
     *     HTTP/1.1 404
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "No profile photo set."
     *       }
     *     }
     */
    public function deleteProfilePhoto(Request $request): JsonResponse
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);

        /** @var File $profilePhoto */
        $profilePhoto = $this->profileService->deleteProfilePhoto($user);

        if (is_array($profilePhoto)) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'message' => $profilePhoto['error'],
                ],
            ], 404);
        }

        return new JsonResponse([
            'success' => true,
            'body' => [
                'message' => 'Profile photo was successfully deleted.',
            ],
        ]);
    }
}
