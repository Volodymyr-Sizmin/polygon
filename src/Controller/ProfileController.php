<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\FileUploadException;
use App\Service\FileUploader;
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
    private const PROFILE_PHOTO = [
        'size' => 39936,
        'height' => 100,
        'width' => 100,
    ];

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
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

        if (empty($profilePhoto)) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'error' => 'No file provided.'
                ]
            ], Response::HTTP_CONFLICT);
        }

        if ($profilePhoto->getSize() > self::PROFILE_PHOTO['size']) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'error' => 'Image size must be 39kb or less.'
                ]
            ], Response::HTTP_CONFLICT);
        }

        $profilePhotoSize = getimagesize($profilePhoto->getPathname());
        if ($profilePhotoSize[1] > self::PROFILE_PHOTO['height'] || $profilePhotoSize[0] > self::PROFILE_PHOTO['width']) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'error' => 'Image resolution must be 100x100.'
                ]
            ], Response::HTTP_CONFLICT);
        }

        try {
            $file = $fileUploader->upload($profilePhoto);
        } catch (FileUploadException $e) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'error' => 'An error occured during upload.'
                ]
            ], Response::HTTP_CONFLICT);
        }

        $entityManager = $this->getDoctrine()->getManager();

//        $user = $this->security->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);

        $user->setProfilePhoto($file->getId());
        $file->setUser($user);

        $entityManager->persist($file);
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse([
            'success' => true,
            'body' => [
                'message' => 'Profile photo was successfully uploaded.'
            ]
        ], 201);
    }
}
