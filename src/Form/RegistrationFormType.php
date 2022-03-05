<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use App\Entity\Localite;
use App\Entity\CodePostal;
use App\Entity\Commune;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'label' => "Adresse mail",
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5']
            ])
            ->add('adresse', null, [
                'label' => "Adresse",
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group col-12 col-sm-10 col-lg-8 col-xl-8']
            ])
            ->add('adresseNum', NumberType::class, [
                'label' => "N°",
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group col-12 col-sm-2 col-lg-2 col-xl-2']
            ])
            ->add('localite', EntityType::class, [
                'class' => Localite::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.localite', 'ASC');
                },
                'attr' => ['class' => 'form-select'],
                'row_attr' => ['class' => 'col-4'],
            ])
            ->add('codePostal', EntityType::class, [
                'class' => CodePostal::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.codePostal', 'ASC');
                },
                'attr' => ['class' => 'form-select'],
                'row_attr' => ['class' => 'col-2'],
            ])
            ->add('commune', EntityType::class, [
                'class' => Commune::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.commune', 'ASC');
                },
                'attr' => ['class' => 'form-select'],
                'row_attr' => ['class' => 'col-4'],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "J'accepte les CGU",
                'row_attr' => ['class' => 'col-12 form-check'],
                'attr' => ['class' => 'form-check-input'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => "Mot de passe",
                'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5'],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit au moins contenir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
