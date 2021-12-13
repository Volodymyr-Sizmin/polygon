<?php

namespace App\Tests\Controller\MyTracklist;

use App\Service\MyTracklist\MyTracklistService;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Factory\TrackFactory;
use App\DTO\Transformer\TracklistTransformerDTO;
use App\DTO\TracklistDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\SerializeController;
use App\Controller\MyTracklist\MyTracklistController;
use Zenstruck\Foundry\Test\Factories;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;

class MyTracklistTest extends WebTestCase
{
    use Factories;

    private $myTracklistServiceMock;
    private $tracklistTransformerDTOMock;
    private $tracklistDTOMock;
    private $jsonResponseMock;
    private $serializeControllerMock;
    private $myTracklistController;
    private $client;
    private EntityManager $entityManager;
    private $requestMock;
    private $fileUploader;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $this->fileUploader = $this->createMock(FileUploader::class);
        $this->tracklistDTOMock = $this->createMock(TracklistDTO::class);
        $this->requestMock = $this->createMock(Request::class);
        $this->myTracklistServiceMock = $this->createMock(MyTracklistService::class);
        $this->tracklistTransformerDTOMock = $this->createMock(TracklistTransformerDTO::class);
        $this->jsonResponseMock = $this->createMock(JsonResponse::class);
        $this->serializeControllerMock = $this->createMock(SerializeController::class);
        $this->myTracklistController = new MyTracklistController($this->myTracklistServiceMock, $this->tracklistTransformerDTOMock);

        TrackFactory::createMany(10);
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/api/mytracklist');

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $this->myTracklistServiceMock->expects($this->any())->method('indexService');
        $this->serializeControllerMock->expects($this->any())->method('serializeJson');
        $this->jsonResponseMock->expects($this->any())->method('fromJsonString');
        $this->myTracklistController->index();
    }

    public function testCrete(): void
    {
        $this->client->request('GET', '/api/mytracklist/create');

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->myTracklistServiceMock->expects($this->any())->method('indexService');
        $this->serializeControllerMock->expects($this->any())->method('serializeJson');
        $this->jsonResponseMock->expects($this->any())->method('fromJsonString');
        $this->myTracklistController->create();
    }

    /**
     * @TODO fix this test
     */
//    public function testStore(): void
//    {
//        $tracklistDTO = new TracklistDTO();
//        $tracklistDTO->title = 'testTitle';
//        $tracklistDTO->author = 'testAuthor';
//        $tracklistDTO->type = 'testType';
//        $tracklistDTO->genre = 'test';
//
//        $this->expectException(NotNullConstraintViolationException::class);
//
//        $this->fileUploader
//             ->expects($this->once())
//             ->method('upload')
//         ;
//
//        $this->tracklistTransformerDTOMock
//             ->expects($this->once())
//             ->method('transformerDTO')
//             ->willReturn($tracklistDTO)
//         ;
//
//        $this->myTracklistServiceMock
//             ->expects($this->once())
//             ->method('storeService')
//             ->with($tracklistDTO)
//         ;
//
//        $this->serializeControllerMock
//             ->expects($this->once())
//             ->method('serializeJson')
//             ->with($this->myTracklistServiceMock)
//         ;
//
//        $this->jsonResponseMock->expects($this->any())
//             ->method('fromJsonString')
//             ->with($this->serializeControllerMock)
//         ;
//
//        $this->myTracklistController->store($this->requestMock);
//
//        $this->client->request('GET', '/api/mytracklist');
//
//        $response = $this->client->getResponse();
//
//        var_dump($response);
//
//        $this->assertSame(200, $response->getStatusCode());
//    }

    public function testShow(): void
    {
        $this->client->request('GET', '/api/mytracklist');

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $this->myTracklistServiceMock->expects($this->any())->method('indexService');
        $this->serializeControllerMock->expects($this->any())->method('serializeJson');
        $this->jsonResponseMock->expects($this->any())->method('fromJsonString');
        $this->myTracklistController->index();
    }
}
