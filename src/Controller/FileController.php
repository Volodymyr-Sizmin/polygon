<?php

namespace App\Controller;

use App\Entity\File;
use App\Exception\FileUploadException;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends AbstractController
{
    public function upload(Request $request, FileUploader $fileUploader): Response
    {
        $uploadedFiles = $request->files->get('files');

        if (empty($uploadedFiles)) {
            return new JsonResponse('No files provided!', Response::HTTP_CONFLICT);
        }

        $maxFileNum = $this->getParameter('uploads_max_file_num');

        if (count($uploadedFiles) > $maxFileNum) {
            return new JsonResponse('Max allowed files number is : ' . $maxFileNum, Response::HTTP_CONFLICT);
        }

        $errors = [];
        /** @var $file UploadedFile */
        foreach ($uploadedFiles as $file) {
            try {
                $fileUploader->upload($file);
            } catch (FileUploadException $e) {
                $errors[$file->getClientOriginalName()] = $e->getMessage();
            }
        }

        if (empty($errors)) {
            return new JsonResponse(["success" => true]);
        }

        return new JsonResponse($errors, Response::HTTP_CONFLICT);
    }
}