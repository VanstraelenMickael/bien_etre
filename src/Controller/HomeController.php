<?php

namespace App\Controller;

use App\Entity\CategorieDeServices;
use App\Entity\Commune;
use App\Entity\CodePostal;
use App\Entity\Localite;
use App\Entity\Prestataire;
use App\Entity\Internaute;
use App\Entity\Images;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(EntityManagerInterface $entitymanager): Response
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

        $repository = $entitymanager->getRepository(Prestataire::class);
        $prestataires = $repository->findLatest();

        $repository = $entitymanager->getRepository(Internaute::class);
        $internaute = $repository->findLastAvailable();

        return $this->render('home/index.html.twig', [
            "categories" => $categories,
            "codePostaux" => $codePostaux,
            "communes" => $communes,
            "localites" => $localites,
            "prestataires" => $prestataires,
            "categorieEnAvant" => $enAvant[0]
        ]);
    }
}
