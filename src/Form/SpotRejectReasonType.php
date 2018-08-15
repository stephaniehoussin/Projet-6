<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpotRejectReasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Spot', ChoiceType::class,array(
                'label' => 'Spot',
                'placeholder'=> 'Choisir',
                'choices' =>array(
                    'Le spot n\'est pas en extérieur' => 'Le spot n\'est pas en extérieur',
                    'Le spot n\'est pas en ville' => 'Le spot n\'est pas en ville'
                ),
                'required' => false
            ))
            ->add('Image', ChoiceType::class,array(
                'label' => 'Image',
                'placeholder' => 'Choisir',
                'choices' =>array(
                    'La photo n\'est pas adaptée' => 'La photo n\'est pas adaptée',
                    'La photo n\'est pas éthique' => 'La photo n\'est pas éthique'
                ),
                'required' => false
            ))
            ->add('Contenu' , ChoiceType::class,array(
                'label' => 'Contenu',
                'placeholder' => 'Choisir',
                'choices' => array(
                    'Le contenu est injurieux' => 'Le contenu est injurieux',
                    'Le contenu n\'est pas adapté' => 'Le contenu n\'est pas adapté'
                ),
                'required' => false
            ))
            ->add('Informations', TextareaType::class,array(
                'label' => 'Informations supplémentaires'
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}

