<?php

namespace App\Tests\Controller\MyTracklist;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Factory\TrackFactory;
use App\Interfaces\MyTracklist\MyTracklistInterface;
use App\DTO\Transformer\TracklistTransformerDTO;
use App\DTO\TracklistDTO;
use Symfony\Component\HttpFoundation\JsonResponse; 
use App\Controller\SerializeController;
use App\Controller\MyTracklist\MyTracklistController;
use Zenstruck\Foundry\Test\Factories;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MyTracklistTest extends WebTestCase
{
    use Factories;

    private $myTracklistInterfaceMock;
    private $tracklistTransformerDTOMock;
    private $tracklistDTOMock;
    private $jsonResponseMock;
    private $serializeControllerMock;
    private $myTrackliscController;
    private $client;
    private EntityManager $entityManager;
    private $requestMock;
    private $fileUploaderMock;
    private $uploadedFileMock;

    public function setUp():void
    {
        $this->client = static::createClient();

        $this->uploadedFileMock            = $this->createMock(UploadedFile::class);
        $this->fileUploaderMock            = $this->createMock(FileUploader::class);
        $this->tracklistDTOMock            = $this->createMock(TracklistDTO::class);
        $this->requestMock                 = $this->createMock(Request::class);
        $this->myTracklistInterfaceMock    = $this->createMock(MyTracklistInterface::class);
        $this->tracklistTransformerDTOMock = $this->createMock(TracklistTransformerDTO::class);
        $this->jsonResponseMock            = $this->createMock(JsonResponse::class);
        $this->serializeControllerMock     = $this->createMock(SerializeController::class);
        $this->myTrackliscController       = new MyTracklistController($this->myTracklistInterfaceMock, $this->tracklistTransformerDTOMock);

        TrackFactory::createMany(10);
    }

    public function testIndex(): void
    {
        
        $this->client->request('GET', '/api/mytracklist');

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $this->myTracklistInterfaceMock->expects($this->any())->method('indexService');
        $this->serializeControllerMock->expects($this->any())->method('serializeJson');
        $this->jsonResponseMock->expects($this->any())->method('fromJsonString');
        $this->myTrackliscController->index();
    }

    public function testCrete(): void
    {
        $this->client->request('GET', '/api/mytracklist/create');

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->myTracklistInterfaceMock->expects($this->any())->method('indexService');
        $this->serializeControllerMock->expects($this->any())->method('serializeJson');
        $this->jsonResponseMock->expects($this->any())->method('fromJsonString');
        $this->myTrackliscController->create();
    }

    public function testShow():void
    {
        $this->client->request('GET', '/api/mytracklist/1');

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $this->myTracklistInterfaceMock->expects($this->any())->method('indexService');
        $this->serializeControllerMock->expects($this->any())->method('serializeJson');
        $this->jsonResponseMock->expects($this->any())->method('fromJsonString');
        $this->myTrackliscController->show(1);
    }

    public function testEdit():void
    {
        $this->client->request('GET', '/api/mytracklist/1/edit');

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $this->myTracklistInterfaceMock->expects($this->any())->method('indexService');
        $this->serializeControllerMock->expects($this->any())->method('serializeJson');
        $this->jsonResponseMock->expects($this->any())->method('fromJsonString');
        $this->myTrackliscController->edit(1);
    }

    public function testDelete():void
    {
        $this->client->request('DELETE', '/api/mytracklist/1');

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $this->myTracklistInterfaceMock->expects($this->any())->method('indexService');
        $this->serializeControllerMock->expects($this->any())->method('serializeJson');
        $this->jsonResponseMock->expects($this->any())->method('fromJsonString');
        $this->myTrackliscController->delete(1);
    }
}
