<?php

namespace App\Controller;

use App\Entity\CategorieDeServices;
use App\Entity\Prestataire;
use App\Entity\Images;
use App\Entity\Commune;
use App\Entity\CodePostal;
use App\Entity\Localite;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PrestatairesController extends AbstractController
{
    /**
     * @Route("/prestataires", name="prestataires")
     */
    public function index(EntityManagerInterface $entitymanager, Request $request, PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();
        if($user && (!$user->getPrestataire() && !$user->getInternaute())){
            // Redirect form fin inscription
            return $this->redirectToRoute('app_register_end');
        }
        
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

        if($prestataires_form){
            $final_result = $paginator->paginate(
                $prestataires_form, 
                $request->query->getInt('page', 1),
                10
            );
        }else{
            $final_result = false;
        }
        
        return $this->render('prestataires/index.html.twig', [
            "prestataires" => $prestataires,
            "categorieEnAvant" => $enAvant[0],
            "prestataires_form" => $final_result
        ]);
    }

    /**
     * @Route("/prestataires/{id}", name="prestataire_details")
     */
    public function details(EntityManagerInterface $entitymanager, Request $request, Prestataire $prestataire): Response
    {
        $user = $this->getUser();
        if($user && (!$user->getPrestataire() && !$user->getInternaute())){
            // Redirect form fin inscription
            return $this->redirectToRoute('app_register_end');
        }

        $services = $prestataire->getServices();
        $repository = $entitymanager->getRepository(Prestataire::class);
        if($services != null && $services[0] != null) {
            $prestataires = $repository->findFromServices($services[0]->getId());
        }else{
            $prestataires = $repository->findLatest();
        }

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
