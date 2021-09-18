<?php

// src/Service/FileUploader.php
namespace App\Service;

use App\Entity\File;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    const DocumentType = 'document';
    const ImageType = 'image';
    const AudioType = 'audio';

    const ALLOWED_TYPES = [
        'pdf' => self::DocumentType,
        'png' => self::ImageType,
        'jpeg' => self::ImageType,
        'jpg' => self::ImageType,
        'mp3' => self::AudioType,
    ];

    const FileTypes = [
        self::AudioType => 1,
        self::ImageType => 2,
        self::DocumentType => 3,
    ];

    // 10 mb
    const MAX_FILE_SIZE = 10000000;

    private $targetDirectory;
    private $slugger;
    private $em;

    public function __construct($targetDirectory, SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        $this->em = $em;
    }

    public function upload(UploadedFile $file): string
    {
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            return 'max allowed file size is: ' . self::MAX_FILE_SIZE;
        }

        $ext = $file->guessExtension();
        if (is_null($ext) || !isset(self::ALLOWED_TYPES[$ext])) {
            return $ext . ' extension is not allowed';
        }

        $fileType = self::ALLOWED_TYPES[$ext];
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $ext;

        $dir = $this->getTargetDirectory() . '/' . $fileType;
        try {
            $file->move($dir, $fileName);
        } catch (FileException $e) {
            return $e->getMessage();
        }

        $file = new File();
        $file->setFilename($originalFilename);
        $file->setTypeId(self::FileTypes[$fileType]);
        $file->setUrl( self::ALLOWED_TYPES[$ext] . '/'. $fileName);

        $this->em->persist($file);
        $this->em->flush($file);

        return "";
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}