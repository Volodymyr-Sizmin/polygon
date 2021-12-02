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
}
