<?php

namespace App\Controller;

use App\Entity\CategorieDeServices;
use App\Entity\Prestataire;
use App\Entity\Images;
use App\Entity\Commune;
use App\Entity\CodePostal;
use App\Entity\Localite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ServicesController extends AbstractController
{
    /**
     * @Route("/services/{id}", name="services")
     */
    public function index(CategorieDeServices $service, EntityManagerInterface $entitymanager): Response
    {
        $repository = $entitymanager->getRepository(CategorieDeServices::class);
        $categories = $repository->findAll();
        $enAvant = $repository->findBy(
            array('enAvant' => '1')
        );
        // Si pour une quelconque raison aucune catégorie n'est mise en avant, j'affiche la dernière catégorie créée.
        if(empty($enAvant)){
            $enAvant = $repository->findLast();
        }

        $repository = $entitymanager->getRepository(Prestataire::class);
        $prestataires = $repository->findFromServices($service->getId());

        $repository = $entitymanager->getRepository(CodePostal::class);
        $codePostaux = $repository->findBy(
            array(),
            array('codePostal' => 'ASC')
        );
        $repository = $entitymanager->getRepository(Commune::class);
        $communes = $repository->findBy(
            array(),
            array('commune' => 'ASC')
        );

        $repository = $entitymanager->getRepository(Localite::class);
        $localites = $repository->findBy(
            array(),
            array('localite' => 'ASC')
        );
        
        return $this->render('services/index.html.twig', [
            "categories" => $categories,
            "codePostaux" => $codePostaux,
            "communes" => $communes,
            "localites" => $localites,
            "prestataires" => $prestataires,
            "categorieEnAvant" => $enAvant[0],
            "service" => $service
        ]);
    }
}
