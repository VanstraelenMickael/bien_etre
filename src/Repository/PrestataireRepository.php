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
        $categorie = $request->request->get('categorie');
        $codePostal = $request->request->get('codePostal');
        $commune = $request->request->get('commune');
        $localite = $request->request->get('localite');

        return $this->createQueryBuilder('p')
            // ->join('services', 's','WITH', 'p.services.id = s.id')
            ->join('p.user','u','WITH', 'u.id = p.user')
            ->join('u.codePostal', 'cp', 'WITH', 'cp.id= u.codePostal')
            ->join('u.commune', 'co', 'WITH', 'co.id= u.commune')
            ->join('u.localite', 'lo', 'WITH', 'lo.id= u.localite')
            ->andWhere('p.nom LIKE :nom')
            // si $codePostal != "none" ?
            ->andWhere('cp.id = :cp')
            // si $commune != "none" ? 
            ->andWhere('co.id = :co')
            // si $localite != "none" ?
            ->andWhere('lo.id = :lo')
            ->setParameter('nom', '%'.$nom.'%')
            ->setParameter('cp', $codePostal)
            ->setParameter('co', $commune)
            ->setParameter('lo', $localite)
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
