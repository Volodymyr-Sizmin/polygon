<?php

namespace App\Tests\Controller\MyTracklist;

use App\Tests\Stubs\Service\FileUploaderStub;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Factory\TrackFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Zenstruck\Foundry\Test\Factories;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Controller\SerializeController;

class MyTracklistTest extends WebTestCase
{
    use Factories;

    private $faker;
    protected $client;
    private $fileUploaderStub;
    private $track;
    private $serializeController;


    public function setUp(): void
    {
        $this->serializeController = new SerializeController();
        $this->client = self::createClient();
        $fileUploaderStub = new FileUploaderStub();
        $this->fileUploaderStub = self::$container->set(FileUploader::class, $fileUploaderStub);
        $this->faker = Factory::create();
        $this->track = TrackFactory::createMany(10);
    }


    public function testIndex(): void
    {
        $this->client->request('GET', '/api/mytracklist');
        $this->assertInstanceOf(JsonResponse::class, $this->client->getResponse());
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testCrete(): void
    {
        $this->client->request('GET', '/api/mytracklist/create');
        $this->assertInstanceOf(JsonResponse::class, $this->client->getResponse());
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testStoreSuccess(): void
    {
        $photo = new UploadedFile(
            $this->faker->image('/tmp', 100, 100),
            "image_name" . '.png',
            'image/png',
            null,
            true
        );
        $this->client->request(
            'POST',
            '/api/mytracklist',
            [
            'author' => 'author',
            'title' => 'title',
            'album' => 'album',
            'type' => 'Music',
            'genre' => 'genre'],
            [
            'cover' => $photo,
            'trackPath' => $photo
            ]
        );
        $this->assertInstanceOf(JsonResponse::class, $this->client->getResponse());
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }

    public function testStoreExpectMessageNotCorrectSymbols(): void
    {
        $photo = new UploadedFile(
            $this->faker->image('/tmp', 100, 100),
            "image_name" . '.png',
            'image/png',
            null,
            true
        );
        $this->client->request(
            'POST',
            '/api/mytracklist',
            [
                'author' => 'author',
                'title' => '.s.',
                'album' => 'album',
                'type' => 'Music',
                'genre' => 'genre'],
            [
                'cover' => $photo,
                'trackPath' => $photo
            ]
        );
        $this->assertInstanceOf(JsonResponse::class, $this->client->getResponse());
        $this->assertResponseStatusCodeSame(400);
    }

    public function testShowSuccess(): void
    {
        $this->client->request('GET', '/api/mytracklist/2');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertInstanceOf(JsonResponse::class, $this->client->getResponse());
    }

    public function testShowNotFoundTrack(): void
    {
        $this->client->request('GET', '/api/mytracklist/11');
        $this->assertResponseStatusCodeSame(404);
        $this->assertInstanceOf(JsonResponse::class, $this->client->getResponse());
        $this->assertSame('{"success":false,"body":"Can not find track"}', $this->client->getResponse()->getContent());
    }

    public function testEditSuccess(): void
    {
        $this->client->request('GET', '/api/mytracklist/2/edit');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertInstanceOf(JsonResponse::class, $this->client->getResponse());
    }

    public function testEditNotFoundTrack(): void
    {
        $this->client->request('GET', '/api/mytracklist/11/edit');
        $this->assertResponseStatusCodeSame(404);
        $this->assertInstanceOf(JsonResponse::class, $this->client->getResponse());
        $this->assertSame('{"success":false,"body":"Can not find track"}', $this->client->getResponse()->getContent());
    }

    public function testUpdateSuccess(): void
    {
        $photo = new UploadedFile(
            $this->faker->image('/tmp', 100, 100),
            "image_name" . '.png',
            'image/png',
            null,
            true
        );
        $this->client->request(
            'POST',
            '/api/mytracklist',
            [
                'author' => 'author',
                'title' => 'title',
                'album' => 'album',
                'type' => 'Music',
                'genre' => 'genre'],
            [
                'cover' => $photo,
                'trackPath' => $photo
            ]
        );
        $this->assertInstanceOf(JsonResponse::class, $this->client->getResponse());
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }

    public function testDelete(): void
    {
        $this->client->request('DELETE', '/api/mytracklist/2');
        $this->assertInstanceOf(JsonResponse::class, $this->client->getResponse());
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }
}
