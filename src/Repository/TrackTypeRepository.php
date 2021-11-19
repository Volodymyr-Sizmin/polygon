<?php

namespace App\Repository;

use App\Entity\TrackType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrackType|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrackType|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrackType[]    findAll()
 * @method TrackType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrackTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrackType::class);
    }

    // /**
    //  * @return TrackType[] Returns an array of TrackType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrackType
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
