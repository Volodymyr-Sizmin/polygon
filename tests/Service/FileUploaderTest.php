<?php

namespace App\Tests\Feature\Service;

use App\Service\FileUploader;
use Doctrine\ORM\EntityManager;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\UnicodeString;

class FileUploaderTest extends TestCase
{
    public const IMAGE_NAME = 'testImage';
    public const IMAGE_FOLDER = 'tmp_files';

    public function testUpload()
    {
        $faker = Factory::create();
        $image = $faker->image();

        $slugger = $this->createMock(SluggerInterface::class);
        $slugger->method('slug')->willReturn(new UnicodeString(self::IMAGE_NAME));

        $em = $this->createMock(EntityManager::class);

        $targetDirectory = getcwd().'/'.self::IMAGE_FOLDER;
        $testUpload = new FileUploader($targetDirectory, $slugger, $em);

        $file = new UploadedFile($image, self::IMAGE_NAME.'.png', 'image/png', null, true);

        $testUpload->upload($file);

        $files = glob(self::IMAGE_FOLDER.'/'.FileUploader::IMAGE_TYPE.'/*');
        $this->assertCount(1, $files);
    }

    protected function tearDown(): void
    {
        $folder_path = self::IMAGE_FOLDER.'/'.FileUploader::IMAGE_TYPE;
        $files = glob($folder_path.'/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir(self::IMAGE_FOLDER.'/'.FileUploader::IMAGE_TYPE);
        rmdir(self::IMAGE_FOLDER);
    }
}
