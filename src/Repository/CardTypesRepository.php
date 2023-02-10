<?php

namespace App\Repository;

use App\Entity\CardTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CardTypes>
 *
 * @method CardTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardTypes[]    findAll()
 * @method CardTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardTypes::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CardTypes $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(CardTypes $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

//    public function findAllByChosenField($fields)
//    {
//        $qb = $this->createQueryBuilder('c');
//        $qb->select($fields);
//
//        return $qb->getQuery()->getResult();
//    }
}
