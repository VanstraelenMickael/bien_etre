<?php

namespace App\Form;

use App\Entity\Internaute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class InternauteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', null, [
            'label' => "Nom",
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5']
        ])
        ->add('prenom', null, [
            'label' => "Prénom",
            'attr' => ['class' => 'form-control'],
            'row_attr' => ['class' => 'form-group col-12 col-sm-12 col-lg-5 col-xl-5']
        ])
        ->add('newsletter', CheckboxType::class, [
            'label' => "Je m'inscrit à la newsletter",
            'row_attr' => ['class' => 'col-12 form-check'],
            'attr' => ['class' => 'form-check-input'],
            'mapped' => false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Internaute::class,
        ]);
    }
}
