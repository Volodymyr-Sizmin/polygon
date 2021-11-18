<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\FileUploadException;
use App\Service\FileUploader;
use App\Service\ProfileService;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    private $security;
    private $profileService;

    public function __construct(Security $security, ProfileService $profileService)
    {
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
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.message Success message
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": {
     *           "message":"Profile photo was successfully downloaded."
     *       }
     *     }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parameters
     * @apiError {String} body.message Error message
     * @apiErrorExample {json}  Empty json request
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "An error occured during file upload."
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
                    'error' => $validateProfilePhoto['error']
                ]
            ], Response::HTTP_CONFLICT);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);

        $uploadProfilePhoto = $this->profileService->uploadProfilePhoto($user, $profilePhoto);
        if (isset($uploadProfilePhoto['error'])) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'error' => $uploadProfilePhoto['error']
                ]
            ], Response::HTTP_CONFLICT);
        }

        return new JsonResponse([
            'success' => true,
            'body' => [
                'message' => 'Profile photo was successfully uploaded.'
            ]
        ], 201);
    }
}
