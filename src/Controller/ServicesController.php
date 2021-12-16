<?php

namespace App\Controller;

use App\Entity\CategorieDeServices;
use App\Entity\Prestataire;
use App\Entity\Images;

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

        $repository = $entitymanager->getRepository(Prestataire::class);
        $prestataires = $repository->findFromServices($service->getId());
        
        return $this->render('services/index.html.twig', [
            "categories" => $categories,
            "prestataires" => $prestataires,
            "categorieEnAvant" => $enAvant[0],
            "service" => $service
        ]);
    }
}
