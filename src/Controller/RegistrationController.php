<?php

namespace App\Controller;

use App\Entity\CodePostal;
use App\Entity\Commune;
use App\Entity\Images;
use App\Entity\Localite;
use App\Entity\User;
use App\Entity\Prestataire;
use App\Entity\Internaute;
use App\Form\InternauteType;
use App\Form\PrestataireType;
use App\Form\RegistrationChoiceType;
use App\Form\RegistrationFormType;
use App\Repository\CodePostalRepository;
use App\Repository\CommuneRepository;
use App\Repository\LocaliteRepository;
use App\Security\EmailVerifier;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Address;
use Symfony\Component\Form\Form;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if($user){
            // Redirect form home
            return $this->redirectToRoute('home');
        }

        $user = new User();
        $user->setInscription(new DateTime());
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('vanstraelm@isl-edu.be', 'Annuaire Bien-Être'))
                    ->to($user->getEmail())
                    ->subject('Merci de valider votre adresse mail')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email
            $this->addFlash('success', 'Inscription réussie. Veuillez valider votre adresse mail.');
            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        // Il faut être connecté pour valider l'inscription, je dois rediriger vers la connexion si l'utilisateur n'est pas connecté en
        if(!$this->getUser()){
            // $this->redirectToRoute('app_login');
        }

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre mail a bien été confirmé.');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/register_step_two", name="app_register_end")
     */
    public function registerStepTwo(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if($user && ($user->getPrestataire() || $user->getInternaute())){
            // Redirect form home
            return $this->redirectToRoute('home');
        }

        $internaute = new Internaute();
        $internaute->setUser($this->getUser());
        $formInternaute = $this->createForm(InternauteType::class, $internaute);
        $formInternaute->handleRequest($request);

        if ($formInternaute->isSubmitted() && $formInternaute->isValid()) {
            // create new Internaute

            $newsletter = $internaute->getNewsletter();
            if($newsletter != 1) $newsletter = 0;
            $internaute->setNewsletter($newsletter);

            $repository = $entityManager->getRepository(User::class);
            $user = $repository->find($this->getUser()->getId());
            $user->setInternaute($internaute);

            $entityManager->persist($internaute);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Inscription terminée. Vous êtes désormais un Internaute.');
            return $this->redirectToRoute('home');
        }

        $prestataire = new Prestataire();
        $prestataire->setUser($this->getUser());
        $formPrestataire = $this->createForm(PrestataireType::class, $prestataire);
        $formPrestataire->handleRequest($request);

        if ($formPrestataire->isSubmitted() && $formPrestataire->isValid()) {
            // create new Internaute
            $repository = $entityManager->getRepository(User::class);
            $user = $repository->find($this->getUser()->getId());
            $user->setPrestataire($prestataire);

            $logo = $formPrestataire->get('logo')->getViewData();

            $nom_logo = md5(uniqid()).'.'.$logo->guessExtension();

            $logo->move(
                $this->getParameter('images_directory'), $nom_logo
            );

            $logo_img = new Images();
            $logo_img->setImage($nom_logo);
            $logo_img->setOrdre(0);
            $logo_img->setPrestataire($prestataire);

            $prestataire->addImage($logo_img);

            $images = $formPrestataire->get('images')->getViewData();

            foreach($images as $key => $image){
                
                $nom_image = md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'), $nom_image
                );

                $img = new Images();
                $img->setImage($nom_image);
                $img->setOrdre($key + 1);
                $img->setUpdateAt(new DateTime());
                $prestataire->addImage($img);
            }

            $entityManager->persist($prestataire);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Inscription terminée. Vous êtes désormais un Prestataire.');
            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register_two.html.twig', [
            'inscriptConfirm' => $this->getUser()->getInscriptConfirm(), 
            'prestataireForm' => $formPrestataire->createView(),
            'internauteForm' => $formInternaute->createView(),
        ]);
    }
}
