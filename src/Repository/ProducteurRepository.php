<?php

namespace App\Repository;

use App\Entity\Producteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Producteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producteur[]    findAll()
 * @method Producteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProducteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producteur::class);
    }

    public function findBeers(int $produteurid): array
    {
        return $this->findBy($produteurid);
    }



}