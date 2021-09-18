<?php

namespace App\Controller;

use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends AbstractController
{
    const MAX_UPLOADED_FILE_NUM = 10;

    public function upload(Request $request, FileUploader $fileUploader): Response
    {
        $uploadedFiles = $request->files->get('files');
        if (is_null($uploadedFiles)) {
            return new Response('No files provided!');
        }

        if (count($uploadedFiles) > self::MAX_UPLOADED_FILE_NUM) {
            return new Response('Max allowed files number is : ' . self::MAX_UPLOADED_FILE_NUM);
        }

        foreach ($uploadedFiles as $file) {
            $err = $fileUploader->upload($file);
            if ($err !== "") {
                return new Response($err);
            }
        }

        return new Response('All files uploaded!');
    }
}