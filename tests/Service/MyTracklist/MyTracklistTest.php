<?php

namespace App\Tests\Service\MyTracklist;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Track;
use App\Repository\TrackRepository;
use App\Service\MyTraclist\MyTraclistService;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\FileUploader;
use App\DTO\TracklistDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenstruck\Foundry\Test\Factories;
use App\Factory\TrackFactory;

class MyTracklistTest extends WebTestCase
{
    use Factories;

    private $myTracklistService;

    private $entityManagerMock;

    private $trackRepositoryMock;

    private $track;

    private $fileUploaderMock;

    private $tracklistDto;

    private $uploadedFileMock;

    private $dateTimeImmutable;

    public function setUp(): void
    {
        parent::setUp();

        $this->fileUploaderMock = $this->createMock(FileUploader::class);
        $this->uploadedFileMock = $this->createMock(UploadedFile::class);

        $this->track = TrackFactory::createMany(5);

        $this->trackRepositoryMock = $this
                                     ->getMockBuilder(TrackRepository::class)
                                     ->disableOriginalConstructor()
                                     ->getMock();
        
        $this->entityManagerMock = $this
                                   ->getMockBuilder(EntityManagerInterface::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->entityManagerMock   ->expects($this->any())
                                   ->method('getRepository')
                                   ->willReturn($this->trackRepositoryMock);

        $this->myTracklistService = new MyTraclistService($this->entityManagerMock, $this->fileUploaderMock);
    }

    public function testIndexService(): void
    {
        $this->trackRepositoryMock->expects($this->any())
                                  ->method('findAll')
                                  ->willReturn([$this->track]);
        
        $expected = $this->entityManagerMock->getRepository(Track::class)->findAll();
        $testMethod = $this->myTracklistService->indexService();
        $this->assertSame($expected,$testMethod);
    }

    public function testCreateService(): void
    {
        $expected = array([
            'trackType' => ['Book', 'Podcast', 'Music'],
            'genreType' => [
                'Rock',
                'Pop', 
                'Classical', 
                'Jazz', 
                'Blues', 
                'Hip-Hop', 
                'Hardcore', 
                'Metal', 
                'Trance', 
                'House', 
                'Punk', 
                'Grunge', 
                'Folk',
                "Drum'n'bass",
                'Russian Chanson', 
                'Retro', 
                'Funk', 
                'Ethnic', 
                'Reggae', 
                'Lounge'
            ]
        ]);

        $testMethod = $this->myTracklistService->createService();

        $this->assertSame($expected,$testMethod);
    }

    public function testStoreServiceIfAlbumAndCoverIsNULL():void
    {
        $this->tracklistDto = $this->createMock(TracklistDTO::class);

        $this->tracklistDto->title = 'My live';
        $this->tracklistDto->author = 'Deskot';
        $this->tracklistDto->track_path = $this->uploadedFileMock;
        $this->tracklistDto->type = 'Music';
        $this->tracklistDto->genre = 'Rock';

        $this->fileUploaderMock->expects($this->any())
                               ->method('upload')
                               ->with($this->tracklistDto->track_path)
                               ->willReturn(new class
                               {
                                   public function getUrl()
                                   {
                                       return 'URL';
                                   }
                               });
        
        $track = new Track;

        $track->setAuthor($this->tracklistDto->author);
        $track->setTrackPath($this->fileUploaderMock->upload($this->tracklistDto->track_path)->getUrl());
        $track->setTitle($this->tracklistDto->title);
        $track->setGenre($this->tracklistDto->genre);
        $track->setType($this->tracklistDto->type);
        
        $this->entityManagerMock->expects($this->once())
                                ->method('persist')
                                ->with($track);
        $this->entityManagerMock->expects($this->once())
                                ->method('flush');
        
        $testMethod = $this->myTracklistService->storeService($this->tracklistDto);
        $this->assertSame($track->getAuthor(),$testMethod->getAuthor());
        $this->assertSame($track->getTitle(), $testMethod->getTitle());
        $this->assertSame($track->getTrackPath(),$testMethod->getTrackPath());
        $this->assertSame($track->getType(), $testMethod->getType());
        $this->assertSame($track->getGenre(), $testMethod->getGenre());
        $this->assertSame($track->getCover(), NULL);
        $this->assertSame($track->getAlbum(), NULL);        
    }

    public function testStoreServiceIfAlbumAndCoverIsNotNULL()
    {
        $this->tracklistDto = $this->createMock(TracklistDTO::class);

        $this->tracklistDto->title = 'My live';
        $this->tracklistDto->author = 'Deskot';
        $this->tracklistDto->track_path = $this->uploadedFileMock;
        $this->tracklistDto->type = 'Music';
        $this->tracklistDto->genre = 'Rock';
        $this->tracklistDto->album = 'This is my Live';
        $this->tracklistDto->cover = $this->uploadedFileMock;

        $this->fileUploaderMock->expects($this->any())
                               ->method('upload')
                               ->with($this->tracklistDto->track_path)
                               ->willReturn(new class
                               {
                                   public function getUrl()
                                   {
                                       return 'URL TRACK';
                                   }
                               });
        $this->fileUploaderMock->expects($this->any())
                               ->method('upload')
                               ->with($this->tracklistDto->cover)
                               ->willReturn(new class
                               {
                                   public function getUrl()
                                   {
                                       return 'URL IMAGE';
                                   }
                               });

        $track = new Track;

        $track->setAuthor($this->tracklistDto->author);
        $track->setTrackPath($this->fileUploaderMock->upload($this->tracklistDto->track_path)->getUrl());
        $track->setTitle($this->tracklistDto->title);
        $track->setGenre($this->tracklistDto->genre);
        $track->setType($this->tracklistDto->type);
        $track->setAlbum($this->tracklistDto->album);
        $track->setCover($this->fileUploaderMock->upload($this->tracklistDto->cover)->getUrl()); 
        
        $this->entityManagerMock->expects($this->once())
                                ->method('persist')
                                ->with($track);
        $this->entityManagerMock->expects($this->once())
                                ->method('flush');
        
        $testMethod = $this->myTracklistService->storeService($this->tracklistDto);
        
        $this->assertSame($track->getAlbum(), $testMethod->getAlbum());
        $this->assertSame($track->getCover(),$testMethod->getCover());
    }

    public function testShowServiceSuccess():void
    {
        $this->trackRepositoryMock->expects($this->any())
                                  ->method('find')
                                  ->with(2)
                                  ->willReturn([$this->track]);
        
        $expected = $this->entityManagerMock->getRepository(Track::class)->find(2);
        $testMethod = $this->myTracklistService->showService(2);

        $this->assertSame($expected,$testMethod);
    }

    public function testShowServiceError():void
    {
        $this->trackRepositoryMock->expects($this->any())
                                  ->method('find')
                                  ->with(10)
                                  ->willReturn([$this->track]);
        
        $expected = $this->entityManagerMock->getRepository(Track::class)->find(10);
        $testMethod = $this->myTracklistService->showService(10);

        $this->assertSame($expected,$testMethod);
    }

    public function testDeleteServiceSuccess():void
    {
         $this->trackRepositoryMock->expects($this->any())
                                                ->method('find')
                                                ->with(1)
                                                ->willReturn($this->track);

        $this->entityManagerMock->expects($this->any())
                                ->method('remove');

        $this->entityManagerMock->expects($this->any())
                                ->method('flush');

        $this->entityManagerMock->remove($this->trackRepositoryMock->find(1));
      
        $expected = array([
            'success' => true, 
            'body'    => 'Track successfully deleted'
        ]);

        $testMethod = $this->myTracklistService->deleteService(1);

        $this->assertSame($expected, $testMethod);
    }

    public function testDeleteServiceError():void
    {
        $this->trackRepositoryMock->expects($this->any())
                                    ->method('find')
                                    ->with(-1000);
      
        $expected = array([
            'success' => false,
            'body'    => 'Can not find track'
        ]);

        $testMethod = $this->myTracklistService->deleteService(-1000);

        $this->assertSame($expected, $testMethod);
    }
}