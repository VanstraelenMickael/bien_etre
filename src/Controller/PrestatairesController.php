<?php

namespace App\Controller;

use App\Entity\CategorieDeServices;
use App\Entity\Prestataire;
use App\Entity\Images;
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

        $repository = $entitymanager->getRepository(Prestataire::class);
        $prestataires = $repository->findLatest();
        
        $prestataires_form = $repository->findFromForm($request);

        //var_dump($prestataires_form);
        
        return $this->render('prestataires/index.html.twig', [
            "categories" => $categories,
            "prestataires" => $prestataires,
            "categorieEnAvant" => $enAvant[0],
            "prestataires_form" => $prestataires_form
        ]);
    }
}
