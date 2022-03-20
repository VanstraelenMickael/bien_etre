<?php

namespace App\Controller;

use App\Entity\CategorieDeServices;
use App\Entity\Images;
use App\Form\AddServiceType;
use App\Form\InternauteType;
use App\Form\PrestataireType;
use App\Form\ServicesType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/me", name="me")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = false;
        $role = "none";
        $me = $this->getUser();

        if (!$me) {
            return $this->redirectToRoute('home');
        }

        if($me->getPrestataire()){
            $role = "prestataire";
            $prestataire = $me->getPrestataire();
            $form = $this->createForm(PrestataireType::class, $prestataire);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $logo = $form->get('logo')->getViewData();
                if(gettype($logo) != "string"){
                    $nom_logo = md5(uniqid()).'.'.$logo->guessExtension();

                    $logo->move(
                        $this->getParameter('images_directory'), $nom_logo
                    );

                    $logo_img = new Images();
                    $logo_img->setImage($nom_logo);
                    $logo_img->setOrdre(0);
                    $logo_img->setPrestataire($prestataire);

                    $old_logo = "";
                    foreach($prestataire->getImages() as $img){
                        if($img->getOrdre() == 0){
                            $old_logo = $img;
                        }
                    }

                    if($old_logo != ""){
                        $prestataire->removeImage($old_logo);
                    }
                    $prestataire->addImage($logo_img);
                }

                $images = $form->get('images')->getViewData();

                $galery = $prestataire->getImages();
                $lastOrder = 0;
                foreach($galery as $img){
                    $lastOrder = $lastOrder < $img->getOrdre() ? $img->getOrdre() : $lastOrder;
                }
                
                foreach($images as $key => $image){
                    $nom_image = md5(uniqid()).'.'.$image->guessExtension();
                    $image->move(
                        $this->getParameter('images_directory'), $nom_image
                    );
                    $img = new Images();
                    $img->setImage($nom_image);
                    $img->setOrdre($lastOrder + $key + 1);
                    $img->setUpdateAt(new DateTime());
                    $prestataire->addImage($img);
                }

                $entityManager->persist($prestataire);
                $entityManager->flush();

                $this->addFlash('success', 'Modifications effectuées avec succès.');
                return $this->redirectToRoute('me');
            }
        }

        if($me->getInternaute()){
            $role = "internaute";
            $internaute = $me->getInternaute();
            $form = $this->createForm(InternauteType::class, $internaute);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $newsletter = $internaute->getNewsletter();
                if($newsletter != 1) $newsletter = 0;
                $internaute->setNewsletter($newsletter);

                $avatar = $form->get('avatar')->getViewData();
                if(gettype($avatar) != "string"){
                    $nom_avatar = md5(uniqid()).'.'.$avatar->guessExtension();

                    $avatar->move(
                        $this->getParameter('images_directory'), $nom_avatar
                    );

                    $logo_img = new Images();
                    $logo_img->setImage($nom_avatar);
                    $logo_img->setOrdre(0);
                    $logo_img->setInternaute($internaute);

                    $old_avatar = "";
                    foreach($internaute->getImages() as $img){
                        if($img->getOrdre() == 0){
                            $old_avatar = $img;
                        }
                    }

                    if($old_avatar != ""){
                        $internaute->removeImage($old_avatar);
                    }
                    $internaute->addImage($logo_img);

                $entityManager->persist($internaute);
                $entityManager->flush();
    
                $this->addFlash('success', 'Modifications effectuées avec succès.');
                return $this->redirectToRoute('me');
            }
        }

        if(!$form){
            return $this->redirectToRoute('home');
        }

        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            'role' => $role
        ]);
        }
    }

    /**
     * @Route("/me/category", name="my_categories")
     */
    public function gestion_category(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($this->getUser() && $this->getUser()->getPrestataire()){
            
            // Récupérer la catégorie et l'ajouter au prestataire
            $categoryToAdd = $request->request->get('service') ? $request->request->get('service') : "none";

            $prestataire = $this->getUser()->getPrestataire();

            $repository = $entityManager->getRepository(CategorieDeServices::class);
            $services = $repository->findBy(
                array('valide' => '1'),
                array('nom' => 'ASC'),
            );

            $toAdd = null;
            if($categoryToAdd != "none"){
                $toAdd = $repository->find($categoryToAdd);
                $prestataire->addService($toAdd);
                $entityManager->persist($prestataire);
                $entityManager->flush();
            }

            $serviceProposed = $prestataire->getServices();

            $serviceProposedArray = [];
            foreach($serviceProposed as $service){
                $serviceProposedArray[] = $service;
            }

            $servicesleft = array_diff($services, $serviceProposedArray);

            if($toAdd != null){
                $servicesleft = array_diff($servicesleft, [$toAdd]);
            }
            
            
        }
        else{
            return $this->redirectToRoute('home');
        }

        return $this->render('user/gestion_category.html.twig', [
            'servicesProposed' => $prestataire->getServices(),
            'servicesLeft' => $servicesleft
        ]);
    }

    /**
     * @Route("/me/category/remove/{id}", name="remove_category")
     */
    public function remove_category(Request $request, EntityManagerInterface $entityManager, CategorieDeServices $service)
    {
        if($this->getUser() && $this->getUser()->getPrestataire()){
            
            $prestataire = $this->getUser()->getPrestataire();
            $prestataire->removeService($service);
            $entityManager->persist($prestataire);
            $entityManager->flush();
        }
        else{
            return $this->redirectToRoute('home');
        }
        return $this->redirectToRoute('my_categories');
    }

    /**
     * @Route("/me/category/create", name="create_category")
     */
    public function create_category(Request $request, EntityManagerInterface $entityManager): Response
    {   
        if($this->getUser() && $this->getUser()->getPrestataire()){

        $category = new CategorieDeServices();
        $prestataire = $this->getUser()->getPrestataire();
        $form = $this->createForm(ServicesType::class, $category);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $banner = $form->get('banner')->getViewData();

                $nom_banner = md5(uniqid()).'.'.$banner->guessExtension();

                $banner->move(
                    $this->getParameter('category_directory'), $nom_banner
                );

                $banner_img = new Images();
                $banner_img->setImage($nom_banner);
                $banner_img->setOrdre(0);
                $banner_img->setCategorie($category);

                $prestataire->addService($category);

                $entityManager->persist($category);
                $entityManager->persist($prestataire);
                $entityManager->persist($banner_img);
                $entityManager->flush();

                $this->addFlash('success', 'La catégorie est désormais en attente de validation.');
                return $this->redirectToRoute('my_categories');
            }
        }else{
            return $this->redirectToRoute('home');
        }

        return $this->render('user/create_category.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
