<?php

namespace App\Tests\Controller\MyTracklist;

use App\Service\MyTracklist\MyTracklistService;
use Doctrine\ORM\EntityManagerInterface;
use App\Tests\Stubs\Service\FileUploaderStub;
use App\Service\FileUploader;
use App\DTO\Transformer\TracklistTransformerDTO;
use App\Controller\MyTracklist\MyTracklistController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Factory\TrackFactory;
use Zenstruck\Foundry\Test\Factories;
use Faker\Factory;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class MyTracklistTest extends WebTestCase
{
    use Factories;

    private $faker;
    protected $client;
    private $request;
    private $fileUploaderStub;


    public function setUp(): void
    {
        $this->client = self::createClient();
        $fileUploaderStub = new FileUploaderStub();
        $this->fileUploaderStub = self::$container->set(FileUploader::class, $fileUploaderStub);
        $this->faker = Factory::create();
        TrackFactory::createMany(10);
    }


    public function testIndex(): void
    {
        $this->client->request('GET', '/api/mytracklist');

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testCrete(): void
    {
        $this->client->request('GET', '/api/mytracklist/create');
        $this->assertSame(200,$this->client->getResponse()->getStatusCode());
    }

    public function testStore(): void
    {
        $photo = new UploadedFile($this->faker->image('/tmp', 100, 100), "image_name" . '.png', 'image/png', null, true);
        $this->client->request('POST', '/api/mytracklist', [
            'author'=> 'author',
            'title' => 'title',
            'album' => 'album',
            'type' => 'Music',
            'genre' => 'genre'
        ],[
            'cover' => $photo,
            'track' => $photo
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testShow(): void
    {
        $this->client->request('GET', '/api/mytracklist');

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
    }
}
