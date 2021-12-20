<?php

namespace App\Tests\Stubs\Service;

use App\Interfaces\FileUploaderInterface;

class FileUploaderStub implements  FileUploaderInterface
{
    public function upload($string)
    {
        return new class{
            public  function getUrl()
            {
                return 'image';
            }
        };
    }
}