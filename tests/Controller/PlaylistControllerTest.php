<?php

namespace App\Tests\Controller;

use App\Controller\PlaylistController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Playlist;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use App\Interfaces\Playlist\PlaylistServiceInterface;
use App\Controller\SerializeController;
use Symfony\Component\HttpFoundation\JsonResponse;
use function PHPUnit\Framework\assertSame;

class PlaylistControllerTest extends WebTestCase
{
    protected Playlist $playlist;
    protected EntityManager $entityManager;
    protected KernelBrowser $client;
    private PlaylistServiceInterface $playlistServiceInterface;
    private $playlistController;
    private SerializeController $serializeController;
    private JsonResponse $jsonResponse;

    protected function setUp(): void
    {
         $this->client = static::createClient();
         $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();

         $playlist = new Playlist();

         $playlist->setName('test');
         $playlist->setDescription('test');
         $playlist->setCreatedAt(new \DateTimeImmutable('2021/11/16'));
         $playlist->setUpdatedAt(new \DateTimeImmutable('2021/11/17'));

        $this->entityManager->persist($playlist);
        $this->entityManager->flush();

        $this->playlist = $playlist;

        $this->jsonResponse = $this->createMock(JsonResponse::class);
        $this->serializeController = $this->createMock(SerializeController::class);
        $this->playlistServiceInterface = $this->createMock(PlaylistServiceInterface::class);
        $this->playlistController = new PlaylistController($this->playlistServiceInterface);
    }

    public function testIndex(): void
    {

        $this->client->request('GET','/api/playlists');
        //url is real
        $response = $this->client->getResponse();
        $this->assertSame(200,$response->getStatusCode());

        //expects methods  indexService  / serializeJson / fromJsonString
        $this->playlistServiceInterface->expects($this->any())->method('indexService');
        $this->serializeController->expects($this->any())->method('serializeJson');
        $this->jsonResponse->expects($this->any())->method('fromJsonString');
        $this->playlistController->index();
    }

    public function testShowPlaylist(): void
    {

        $this->client->Request('GET', '/api/playlists/' . $this->playlist->getId(), [], [], []);

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $actualPlaylist = $this->entityManager->find(Playlist::class, $this->playlist->getId());

        $this->assertSame("test", $actualPlaylist->getName());
        $this->assertSame("test", $actualPlaylist->getDescription());
    }

    public function testModifyPlaylist():void
    {
        $this->client->jsonRequest('PUT', '/api/playlists/' . $this->playlist->getId(), [
            "name" => "unitTest",
            "description" => "unitTest"
            ], []);

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $responseArr = json_decode($response->getContent(), true);

        $this->assertSame(true, $responseArr["success"]);
        $this->assertSame("unitTest", $responseArr["playlist"]["name"]);
        $this->assertSame("unitTest", $responseArr["playlist"]["description"]);

        $actualPlaylist = $this->entityManager->find(Playlist::class, $this->playlist->getId());

        $this->assertSame("unitTest", $actualPlaylist->getName());
        $this->assertSame("unitTest", $actualPlaylist->getDescription());
    }

    public function testDelete(): void
    {
        $this->client->jsonRequest('DELETE', '/api/playlists/' . $this->playlist->getId());

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());


        $this->assertSame(null, $this->entityManager->remove($this->playlist));

        $responseArr = json_decode($response->getContent(), true);

        $this->assertSame(true, $responseArr['success']);
        $this->assertSame("Playlist successfully deleted", $responseArr['body']);
    }
}