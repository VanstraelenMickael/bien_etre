<?php

namespace App\Repository;

use App\Entity\CategorieDeServices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieDeServices|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieDeServices|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieDeServices[]    findAll()
 * @method CategorieDeServices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieDeServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieDeServices::class);
    }

    // /**
    //  * @return CategorieDeServices[] Returns an array of CategorieDeServices objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategorieDeServices
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
