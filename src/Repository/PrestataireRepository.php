<?php

namespace App\Repository;

use App\Entity\Prestataire;
use App\Entity\User;
use App\Entity\CategorieDeServices;
use App\Entity\Commune;
use App\Entity\CodePostal;
use App\Entity\Localite;

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
            ->leftJoin('p.user','b','p.user = b.id')
            ->setMaxResults(3)
            ->orderBy('b.inscription', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLast()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(1)
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
            ->join('p.services', 's', 'WITH', 's.id = :id')
            ->setMaxResults(3)
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Prestataire[] Returns an array of Prestataire objects
     */
    public function findFromForm($request)
    {
        $nom = $request->query->get('nom');
        $categorie = $request->query->get('categorie');
        $codePostal = $request->query->get('codePostal');
        $commune = $request->query->get('commune');
        $localite = $request->query->get('localite');

        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.nom', 'ASC')
            ->join('p.user','u')
            ->where('p.nom LIKE :nom');

            if($categorie != "none"){
                $qb ->join('p.services','s','WITH', 's.id = :categorie')
                    ->setParameter('categorie',$categorie);
            }
            
            $qb ->setParameter('nom', '%'.$nom.'%')
                ;

            if($codePostal != "none"){
                $qb ->andWhere('u.codePostal = :cp')
                    ->setParameter('cp', $codePostal);
            }

            if($commune != "none"){
                $qb->andWhere('u.commune = :co')
                ->setParameter('co', $commune);
            }
            if($localite != "none"){
                $qb->andWhere('u.localite = :lo')
                ->setParameter('lo', $localite);
            }

            return $qb->getQuery()->execute();

        //     ->getQuery()
        //     ->getResult();
        // return $qb;

        // $query = $this->createQueryBuilder('p')
        //     // ->join('services', 's','WITH', 'p.services.id = s.id')
        //     ->join('p.user','u','WITH', 'u.id = p.user')
        //     ->andWhere('p.nom LIKE :nom')
        //     ->setParameter('nom', '%'.$nom.'%');
        //     // if($codePostal != "none"){
        //     //     $query->andWhere('u.codePostal = :cp')
        //     //     ->setParameter('cp', $codePostal);
        //     // }
        //     // if($commune != "none"){
        //     //     $query->andWhere('u.commune = :co')
        //     //     ->setParameter('co', $commune);
        //     // }
        //     // if($localite != "none"){
        //     //     $query->andWhere('u.localite = :lo')
        //     //     ->setParameter('lo', $localite);
        //     // }
            
        //     $query->setMaxResults(20)
        //     ->getQuery()
        //     ->getResult()
        // ;

        // return $query;
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
