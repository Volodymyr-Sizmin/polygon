<?php

namespace App\Tests\Service;

use App\Entity\File;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\UnicodeString;

class FileUploaderTest extends TestCase
{
    const IMAGE_NAME = 'testImage';
    const IMAGE_FOLDER = 'tmp_files';

    public function testUpload()
    {
        $faker = Factory::create();
        $image = $faker->image();

        $slugger = $this->createMock(SluggerInterface::class);
        $slugger->method("slug")->willReturn(new UnicodeString(self::IMAGE_NAME));

        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())->method("flush")->will($this->returnCallback(function ($arg) {
            $this->assertInstanceOf(File::class, $arg);
            $this->assertEquals(self::IMAGE_NAME, $arg->getFilename());
            $this->assertNotEmpty($arg->getUrl());
            $this->assertEquals(FileUploader::FILE_TYPES[FileUploader::IMAGE_TYPE], $arg->getTypeId());
        }));

        $targetDirectory = getcwd() . '/' . self::IMAGE_FOLDER;
        $testUpload = new FileUploader($targetDirectory, $slugger, $em);

        $file = new UploadedFile($image, self::IMAGE_NAME . '.png', 'image/png', null, true);

        $testUpload->upload($file);

        $files = glob(self::IMAGE_FOLDER . "/" . FileUploader::IMAGE_TYPE . '/*');
        $this->assertCount(1, $files);
    }

    protected function tearDown(): void
    {
        $folder_path = self::IMAGE_FOLDER . "/" . FileUploader::IMAGE_TYPE;
        $files = glob($folder_path . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir(self::IMAGE_FOLDER . '/'. FileUploader::IMAGE_TYPE);
        rmdir(self::IMAGE_FOLDER);
    }
}
