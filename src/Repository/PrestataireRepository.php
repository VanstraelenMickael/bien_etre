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
        // return $this->createQueryBuilder('p')
        //     ->setMaxResults(3)
        //     // ->where('categorie_de_service.id = '.$id)
        //     ->getQuery()
        //     ->getResult()
        // ;
        return $this->createQueryBuilder('p')
            ->where('p.services = :id')
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
        $categorie = $request->request->get('categorie');
        $nom = $request->request->get('nom');
        $categorie = $request->request->get('categorie');
        $codePostal = $request->request->get('codePostal');
        $commune = $request->request->get('commune');
        $localite = $request->request->get('localite');

        $qb = $this->createQueryBuilder('p')
            ->join('p.user','u')
            ->where('p.nom LIKE :nom');
            
            $qb ->setParameter('nom', '%'.$nom.'%')
                ->setMaxResults(20);

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
