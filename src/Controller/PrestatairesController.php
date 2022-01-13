<?php

namespace App\Controller;

use App\Entity\CategorieDeServices;
use App\Entity\Prestataire;
use App\Entity\Images;
use App\Entity\Commune;
use App\Entity\CodePostal;
use App\Entity\Localite;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PrestatairesController extends AbstractController
{
    /**
     * @Route("/prestataires", name="prestataires")
     */
    public function index(EntityManagerInterface $entitymanager, Request $request): Response
    {
        $repository = $entitymanager->getRepository(CategorieDeServices::class);
        $enAvant = $repository->findBy(
            array('enAvant' => '1')
        );
        // Si pour une quelconque raison aucune catégorie n'est mise en avant, j'affiche la dernière catégorie créée.
        if(empty($enAvant)){
            $enAvant = $repository->findLast();
        }

        $repository = $entitymanager->getRepository(Prestataire::class);
        $prestataires = $repository->findLatest();

        $prestataires_form = $repository->findFromForm($request);
        if(empty($prestataires_form)){
            $prestataires_form = false;
        }
        
        return $this->render('prestataires/index.html.twig', [
            "prestataires" => $prestataires,
            "categorieEnAvant" => $enAvant[0],
            "prestataires_form" => $prestataires_form
        ]);
    }

    /**
     * @Route("/prestataires/{id}", name="prestataire_details")
     */
    public function details(EntityManagerInterface $entitymanager, Request $request, Prestataire $prestataire): Response
    {
        $services = $prestataire->getServices();
        
        $repository = $entitymanager->getRepository(Prestataire::class);
        $prestataires = $repository->findFromServices($services[0]->getId());

        $repository = $entitymanager->getRepository(CategorieDeServices::class);
        $enAvant = $repository->findBy(
            array('enAvant' => '1')
        );
        // Si pour une quelconque raison aucune catégorie n'est mise en avant, j'affiche la dernière catégorie créée.
        if(empty($enAvant)){
            $enAvant = $repository->findLast();
        }

        return $this->render('prestataires/details.html.twig', [
            "prestataire" => $prestataire,
            "prestataires" => $prestataires,
            "categorieEnAvant" => $enAvant[0],
            "recherche_close" => true
        ]);
    }

}
