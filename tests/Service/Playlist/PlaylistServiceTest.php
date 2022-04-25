<?php

namespace App\Tests\Service\Playlist;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Playlist;
use App\Service\Playlist\PlaylistService;
use App\Repository\PlaylistRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function PHPUnit\Framework\assertSame;

class PlaylistServiceTest extends WebTestCase
{
    private $playlistService;
    private $entityManagerMock;
    private $playlistRepositoryMock;
    private $playlist;
    private $validatorInterface;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIndexServiceReturnArrayWithAllPlaylists(): void
    {
        $this->playlist = new Playlist();

        $this->playlist->setName('test');
        $this->playlist->setDescription('test');
        $this->playlist->setCreatedAt(new \DateTimeImmutable());
        $this->playlist->setUpdatedAt(new \DateTimeImmutable());

        $this->playlistRepositoryMock = $this
                                 ->getMockBuilder(PlaylistRepository::class)
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $this->playlistRepositoryMock->expects($this->any())
                                 ->method('findAll')
                                 ->willReturn([$this->playlist]);

        $this->entityManagerMock = $this
                             ->getMockBuilder(EntityManager::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $this->entityManagerMock->expects($this->any())
                            ->method('getRepository')
                            ->willReturn($this->playlistRepositoryMock);
        $this->validatorInterface = $this
            ->getMockBuilder(ValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->playlistService = new PlaylistService($this->entityManagerMock, $this->validatorInterface);

        $excepted = $this->entityManagerMock->getRepository(Playlist::class)->findAll();
        $testMethod = $this->playlistService->indexService();

        assertSame($excepted, $testMethod);
    }
}
