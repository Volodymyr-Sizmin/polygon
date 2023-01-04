<?php

namespace App\Repository;

use App\Entity\CellPhoneOperators;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CellPhoneOperators>
 * @method CellPhoneOperators|null find($id, $lockMode = null, $lockVersion = null)
 * @method CellPhoneOperators|null findOneBy(array $criteria, array $orderBy = null)
 * @method CellPhoneOperators[]    findAll()
 * @method CellPhoneOperators[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CellPhoneOperatorsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CellPhoneOperators::class);
    }

    public function add(CellPhoneOperators $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(CellPhoneOperators $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
