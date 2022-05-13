<?php

namespace App\Service;

use App\Entity\File;
use App\Entity\User;
use App\Exception\FileUploadException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfileService
{
    private const PROFILE_PHOTO = [
        'size' => 5242880,
        'height' => 100,
        'width' => 100,
    ];

    private $em;
    private $fileUploader;

    public function __construct(EntityManagerInterface $em, FileUploader $fileUploader)
    {
        $this->em = $em;
        $this->fileUploader = $fileUploader;
    }

    /** Validate Profile Photo.
     *
     * @return string[]|bool
     */
    public function validateProfilePhoto(UploadedFile $photo)
    {
        if (empty($photo)) {
            return ['error' => 'No file provided.'];
        }

        if ($photo->getSize() > self::PROFILE_PHOTO['size']) {
            return ['error' => 'Image size must be not bigger than 5mb.'];
        }

        $profilePhotoSize = getimagesize($photo->getPathname());
        if ($profilePhotoSize[1] < self::PROFILE_PHOTO['height'] || $profilePhotoSize[0] < self::PROFILE_PHOTO['width']) {
            return ['error' => 'Image resolution must be not less than 100x100.'];
        }

        return true;
    }

    /** Upload Profile Photo.
     *
     * @return string[]|bool
     */
    public function uploadProfilePhoto(User $user, UploadedFile $photo)
    {
        try {
            $file = $this->fileUploader->upload($photo);
        } catch (FileUploadException $e) {
            return ['error' => 'An error occurred during upload.'];
        }

        $user->setProfilePhoto($file);
        $file->setUser($user);

        $this->em->persist($file);
        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    /** Get Profile Photo.
     *
     * @param User $user Instance of User
     *
     * @return string[]|File $profilePhoto Error message or File
     */
    public function getProfilePhoto(User $user)
    {
        /** @var File $profilePhoto */
        $profilePhoto = $this->em->getRepository(File::class)->find($user->getProfilePhoto());

        if (!$profilePhoto) {
            return ['error' => 'No profile photo set.'];
        }

        return $profilePhoto;
    }

    /** Delete Profile Photo.
     *
     * @return string[]|bool Error message or True
     */
    public function deleteProfilePhoto(User $user)
    {
        /** @var File $profilePhoto */
        $profilePhoto = $this->em->getRepository(File::class)->find($user->getProfilePhoto());

        if (!$profilePhoto) {
            return ['error' => 'No profile photo set.'];
        }

        $this->em->remove($profilePhoto);
        $this->em->flush();

        $user->setProfilePhoto(null);

        return true;
    }
}
