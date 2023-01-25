<?php

namespace App\Repository;

use App\Entity\UtilitiesProvider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UtilitiesProvider>
 *
 * @method UtilitiesProvider|null find($id, $lockMode = null, $lockVersion = null)
 * @method UtilitiesProvider|null findOneBy(array $criteria, array $orderBy = null)
 * @method UtilitiesProvider[]    findAll()
 * @method UtilitiesProvider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilitiesProviderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UtilitiesProvider::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UtilitiesProvider $entity, bool $flush = true): void
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
    public function remove(UtilitiesProvider $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return UtilitiesProvider[] Returns an array of UtilitiesProvider objects
     */
    public function findByUtility(string $utility): array
    {
        return $this->createQueryBuilder('utilityProvider')
            ->andWhere('utilityProvider.utility = :val')
            ->setParameter('val', $utility)
            ->orderBy('utilityProvider.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return string[] Returns an array of all utilities present
     */
    public function getUtilities(): array
    {
        return $this->createQueryBuilder('utilityProvider')
            ->select('utilityProvider.utility')
            ->distinct()
            ->getQuery()
            ->getResult()
            ;
    }

}
