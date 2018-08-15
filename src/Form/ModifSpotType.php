<?php

namespace App\Form;


use App\Entity\Category;
use App\Entity\Spot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class ModifSpotType
 * @package App\Form
 * @Vich\Uploadable
 */
class ModifSpotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class,array(
                'label' => 'Modifier la catégorie',
                'class' => Category::class,
                'required' => false
            ))
            ->add('pictureFile', VichImageType::class,array(
                'label' => 'Modifier la photo',
                'required' => false
            ))
            ->add('title', TextType::class,array(
                'label' => 'Modifier le titre',
                'required' => false
            ))
            ->add('description', TextareaType::class,array(
                'label' => 'Modifier la description',
                'required' => false
            ))
            ->add('infosSupp', TextareaType::class,array(
                'label' => 'Modifier l\'adresse',
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class
        ]);
    }


}