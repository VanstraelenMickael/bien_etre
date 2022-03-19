<?php

namespace App\Form;

use App\Entity\CategorieDeServices;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', null, [
            'label' => "Nom de la catégorie",
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-10 col-lg-8 col-xl-8']
        ])
        ->add('description', TextareaType::class, [
            'label' => "Description",
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-10 col-lg-8 col-xl-8']
        ])
        ->add('banner', FileType::class, [
            'label' => "Bannière de la catégorie",
            'multiple' => false,
            'mapped' => false,
            'required' => true,
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieDeServices::class,
        ]);
    }
}
