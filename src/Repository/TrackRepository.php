<?php

namespace App\Repository;

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
            ->select('track_path')
            //->from('t')
            ->where('t.id=:id')
            ->setParameter('id', $id);

        $query = $db->getQuery();

        return $query->execute();
    }

    public function getArtistData($id)
    {
        $db = $this->createQueryBuilder('t')
            ->select('author', 'album', 'track', 'name')
            ->where('t.id=:id')
            ->setParameter('id', $id);

        $query = $db->getQuery();

        return $query->execute();
    }
}
