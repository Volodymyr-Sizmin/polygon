<?php

namespace App\Service;

use App\Entity\File;
use App\Exception\FileUploadException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    const DOCUMENT_TYPE = 'document';
    const IMAGE_TYPE = 'image';
    const AUDIO_TYPE = 'audio';

    const PDF_EXTENSION = 'pdf';
    const PNG_EXTENSION = 'png';
    const JPEG_EXTENSION = 'jpeg';
    const JPG_EXTENSION = 'jpg';
    const MP3_EXTENSION = 'mp3';

    const ALLOWED_TYPES = [
        self::PDF_EXTENSION => self::DOCUMENT_TYPE,
        self::PNG_EXTENSION => self::IMAGE_TYPE,
        self::JPEG_EXTENSION => self::IMAGE_TYPE,
        self::JPG_EXTENSION => self::IMAGE_TYPE,
        self::MP3_EXTENSION => self::AUDIO_TYPE,
    ];

    const FILE_TYPES = [
        self::AUDIO_TYPE => 1,
        self::IMAGE_TYPE => 2,
        self::DOCUMENT_TYPE => 3,
    ];

    // 10 mb
    const MAX_FILE_SIZE = 10485760;

    private string $targetDirectory;
    private SluggerInterface $slugger;
    private EntityManagerInterface $em;

    public function __construct($targetDirectory, SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        $this->em = $em;
    }

    public function upload(UploadedFile $file)
    {
        if ($file->getSize() > self::MAX_FILE_SIZE || !$file->getSize()) {
            throw new FileUploadException('max allowed file size is: ' . self::MAX_FILE_SIZE . ' byte.');
        }

        $ext = $file->guessExtension();
        if (is_null($ext) || !isset(self::ALLOWED_TYPES[$ext])) {
            throw new FileUploadException($ext . ' extension is not allowed');
        }

        $fileType = self::ALLOWED_TYPES[$ext];
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = md5($safeFilename) . '-' . uniqid() . '.' . $ext;

        $dir = $this->getTargetDirectory() . '/' . $fileType;
        try {
            $file->move($dir, $fileName);
        } catch (FileException $e) {
            throw new FileUploadException('error moving file from tmp folder');
        }

        $file = new File();
        $file->setFilename($originalFilename);
        $file->setTypeId(self::FILE_TYPES[$fileType]);
        $file->setUrl(self::ALLOWED_TYPES[$ext] . '/' . $fileName);
        $file->setCreatedAt(new \DateTime('NOW'));
        $file->setUpdatedAt(new \DateTime('NOW'));

        $this->em->persist($file);
        $this->em->flush($file);
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}