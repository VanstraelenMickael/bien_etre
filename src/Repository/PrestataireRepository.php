<?php

namespace App\Repository;

use App\Entity\Prestataire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prestataire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestataire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestataire[]    findAll()
 * @method Prestataire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestataireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestataire::class);
    }

    // /**
    //  * @return Prestataire[] Returns an array of Prestataire objects
    //  */
    public function findLatest()
    {
        return $this->createQueryBuilder('p')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Prestataire[] Returns an array of Prestataire objects
     */
    public function findFromServices($id)
    {
        return $this->createQueryBuilder('p')
            ->setMaxResults(3)
            // ->where('categorie_de_service.id = '.$id)
            ->getQuery()
            ->getResult()
        ;
        // return $this->createQueryBuilder('p')
        //     ->select('')
        //     ->from('prestataire_categorie_de_services', 'p')
        //     ->where('p.categorie_de_services_id = '.$id)
        //     ->setMaxResults(3)
        //     ->getQuery()
        //     ->getResult()
        // ;
    }

    /**
     * @return Prestataire[] Returns an array of Prestataire objects
     */
    public function findFromForm($request)
    {
        $categorie = $request->request->get('categorie');
        $nom = $request->request->get('nom');
        return $this->createQueryBuilder('p')
            ->andWhere('p.nom LIKE :nom')
            ->setParameter('nom', '%'.$nom.'%')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Prestataire
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
