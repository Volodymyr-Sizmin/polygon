<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Account>
 *
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Account $entity, bool $flush = true): void
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
    public function remove(Account $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);

        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByAccountNumber(string $accountNumber): ?Account
    {
        return $this->createQueryBuilder('accounts')
            ->andWhere('accounts.number = :val')
            ->setParameter('val', $accountNumber)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param string $cardNumber
     * @return Account|null
     * @throws NonUniqueResultException
     */
    public function findByCardNumber(string $cardNumber): ?Account
    {
        return $this->createQueryBuilder('accounts')
            ->andWhere('accounts.cardNumber = :val')
            ->setParameter('val', $cardNumber)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
