<?php

namespace App\Repository;

use App\Entity\Playlist;
use App\Entity\PlaylistsTracks;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Track;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Track|null find($id, $lockMode = null, $lockVersion = null)
 * @method Track|null findOneBy(array $criteria, array $orderBy = null)
 * @method Track[]    findAll()
 * @method Track[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Track::class);
    }

    public function getTrackPath($id)
    {
        $db = $this->createQueryBuilder('t')
        ->select('t.track_path')
        ->where('t.id=:id')
        ->setParameter('id', $id);

        $query = $db->getQuery();

        return $query->execute();
    }

    public function getArtistData($id)
    {
        $sub = $this->createQueryBuilder('t')
        ->select('t.author')
        ->where('t.id=:id')
        ->setParameter('id', $id);

        $author = $sub->getQuery()->getArrayResult();

        $data = $this->createQueryBuilder('t')
        ->select('t.author, t.title, t.album, t.cover, p.name')
        ->leftJoin('App:PlaylistsTracks', 'p_t', 'WITH', 't.id=p_t.track_id')
        ->leftJoin('App:Playlist', 'p', 'WITH', 'p_t.playlist_id = p.id')
        ->where('t.author=:author')
        ->setParameter('author', $author)
        ->getQuery()
        ->getArrayResult();

        return $data;
    }

    public function getAlbumSong($id)
    {
        $sub = $this->createQueryBuilder('t')
        ->select('t.album')
        ->where('t.id=:id')
        ->setParameter('id', $id);

        $album = $sub->getQuery()->getArrayResult();

        $data = $this->createQueryBuilder('t')
        ->select('t.author, t.title, t.album, t.cover, t.track_path')
        ->where('t.album=:album')
        ->setParameter('album', $album)
        ->getQuery()
        ->getArrayResult();

        return $data;
    }
}
