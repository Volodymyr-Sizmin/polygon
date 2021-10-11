<?php

namespace App\Tests\Feature\Feature;

use App\Service\FileUploader;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class FilesTest extends WebTestCase
{
    const IMAGE_NAME = 'testImage';

    private string $imageFolder;

    protected function setUp(): void
    {
        $this->imageFolder = 'public/' . $_ENV['FILE_UPLOAD_PATH'];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $folder_path = $this->imageFolder . "/" . FileUploader::IMAGE_TYPE;
        if (!is_dir($folder_path)) {
            return;
        }

        $files = glob($folder_path . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        rmdir($this->imageFolder . '/' . FileUploader::IMAGE_TYPE);
        rmdir($this->imageFolder);
    }

    /**
     * @dataProvider uploadProvider
     */
    public function testUpload(array $files, int $statusCode)
    {
        $client = self::createClient();
        $client->request('POST', '/api/file/upload', [], ['files' => $files]);

        $this->assertEquals($statusCode, $client->getResponse()->getStatusCode());

        if ($statusCode == Response::HTTP_OK) {
            $f = glob($this->imageFolder . "/" . FileUploader::IMAGE_TYPE . '/*');
            $this->assertNotEmpty($f);
        }
    }

    public function uploadProvider()
    {
        $faker = Factory::create();

        return [
            [
                [
                    new UploadedFile($faker->image(), "image_name" . '.png', 'image/png', null, true)
                ],
                Response::HTTP_OK,
            ],
            [
                [],
                Response::HTTP_CONFLICT,
            ],
            [
                [
                    new UploadedFile($faker->image(), "image_name" . '.png', 'image/png', null, true),
                    new UploadedFile($faker->image(), "image_name" . '.png', 'image/png', null, true)
                ],
                Response::HTTP_CONFLICT,
            ],
        ];
    }
}