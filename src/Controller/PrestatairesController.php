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
        $categories = $repository->findAll();
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

        //var_dump($prestataires_form);
        
        return $this->render('prestataires/index.html.twig', [
            "categories" => $categories,
            "codePostaux" => $codePostaux,
            "communes" => $communes,
            "localites" => $localites,
            "prestataires" => $prestataires,
            "categorieEnAvant" => $enAvant[0],
            "prestataires_form" => $prestataires_form
        ]);
    }
}
