<?php

namespace App\Form;

use App\Entity\CategorieDeServices;
use App\Entity\Prestataire;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestataireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', null, [
            'label' => "Nom",
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5']
        ])
        ->add('siteweb', null, [
            'label' => "Votre site web",
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5']
        ])
        ->add('numTel', null, [
            'label' => "Votre numéro de téléphone",
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5']
        ])
        ->add('numTva', null, [
            'label' => "Votre numéro de TVA",
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5']
        ])
        ->add('logo', FileType::class, [
            'label' => "Votre logo",
            'multiple' => false,
            'mapped' => false,
            'required' => false,
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5']
        ])
        ->add('images', FileType::class, [
            'label' => "Vos images",
            'multiple' => true,
            'mapped' => false,
            'required' => false,
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prestataire::class,
        ]);
    }
}
