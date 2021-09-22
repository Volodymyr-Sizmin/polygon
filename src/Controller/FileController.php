<?php

namespace App\Controller;

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
        if (is_null($uploadedFiles)) {
            return new Response('No files provided!');
        }

        $maxFileNum = $this->getParameter('uploads_max_file_num');
        if (count($uploadedFiles) > $maxFileNum) {
            return new Response('Max allowed files number is : ' . $maxFileNum);
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

        return new JsonResponse($errors);
    }
}