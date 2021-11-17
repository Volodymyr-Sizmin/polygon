<?php

namespace App\Tests\Service\Playlist;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Playlist;
use App\Service\Playlist\PlaylistService;
use Doctrine\ORM\EntityManagerInterface;

use function PHPUnit\Framework\assertSame;

class PlaylistServiceKernelTest extends KernelTestCase
{

    private $entityManager;

    private $playlistService;

    public function setup(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $playlist = new Playlist();

        $playlist->setName('test');
        $playlist->setDescription('test');
        $playlist->setCreatedAt(new \DateTimeImmutable('2021/11/16'));
        $playlist->setUpdatedAt(new \DateTimeImmutable('2021/11/17'));
    
        $this->entityManager->persist($playlist);
        $this->entityManager->flush();
    
        $this->playlist = $playlist;
        
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->playlistService = new PlaylistService($this->entityManagerMock);
    }

    public function testIndexService()
    {
        $playlist =$this->entityManager->getRepository(Playlist::class)
                            ->findAll();
        $testMethod = $this->playlistService->indexService();

        assertSame($testMethod,2);
    }
}
