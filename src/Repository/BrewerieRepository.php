<?php

namespace App\Repository;

use App\Entity\Brewerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Brewerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brewerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brewerie[]    findAll()
 * @method Brewerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrewerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brewerie::class);
    }

    // /**
    //  * @return Brewerie[] Returns an array of Brewerie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Brewerie
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
