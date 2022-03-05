<?php

namespace App\Controller;

use App\Entity\CodePostal;
use App\Entity\Commune;
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
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
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
        $repository = $entityManager->getRepository(CodePostal::class);
        $codePostaux = $repository->findBy(
            array(),
            array('codePostal' => 'ASC')
        );

        $repository = $entityManager->getRepository(Localite::class);
        $localites = $repository->findBy(
            array(),
            array('localite' => 'ASC')
        );

        $repository = $entityManager->getRepository(Commune::class);
        $communes = $repository->findBy(
            array(),
            array('commune' => 'ASC')
        );

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

            return $this->redirectToRoute('home');
        }

        $prestataire = new Prestataire();
        $prestataire->setUser($this->getUser());
        $formPrestataire = $this->createForm(PrestataireType::class, $prestataire);
        $formPrestataire->handleRequest($request);

        if ($formPrestataire->isSubmitted() && $formPrestataire->isValid()) {
            // create new Internaute

            // $entityManager->persist($prestataire);
            // $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register_two.html.twig', [
            'prestataireForm' => $formPrestataire->createView(),
            'internauteForm' => $formInternaute->createView(),
        ]);
    }
}
