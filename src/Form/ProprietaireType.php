<?php

namespace App\Form;

use App\Entity\Proprietaire;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProprietaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('voitures', EntityType::class,
            [
                'class' => Voiture::class,
                'choice_label'=> 'marque',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('voitures', VoitureType::class, [
                'data_class' => null
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proprietaire::class,
        ]);
    }
}
