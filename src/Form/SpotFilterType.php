<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpotFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class,[
                'class'=> Category::class,
                    'label' => 'Filtre par catégories',
                    'placeholder' => 'Choisir',
                    'required' => false]
            )
            ->add('user', EntityType::class,[
                'class' => User::class,
                'label' => 'Filtre par Spoteur',
                'placeholder' => 'Choisir',
                'required' => false
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
