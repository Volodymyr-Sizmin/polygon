<?php

namespace App\Tests\Stubs\Service;

use App\Interfaces\FileUploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderStub implements FileUploaderInterface
{
    public function upload(UploadedFile $file)
    {
        return new class {
            public function getPath()
            {
                return 'image';
            }
        };
    }
}
