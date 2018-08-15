<?php
namespace App\Form;

use App\Entity\Category;
use App\Entity\Spot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class SpotType
 * @package App\Form
 * @Vich\Uploadable
 */
class SpotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('latitude', HiddenType::class,array(
                'label' => 'Latitude'
            ))
            ->add('longitude', HiddenType::class,array(
                'label' => 'Longitude'
            ))
            ->add('category', EntityType::class,array(
                'label' => 'Choisir la catégorie',
                    'class' => Category::class,
            ))
            ->add('pictureFile', VichImageType::class,array(
                'label' => 'Ajouter une image'
            ))
            ->add('title', TextType::class,array(
                'label' => 'Choisir un titre'
            ))
            ->add('description', TextareaType::class,array(
                'label' => 'Ajouter une description'
            ))
            ->add('infosSupp', TextType::class,array(
                'label' => 'Indiquer une adresse ( boulevard de la paix, 3 rue du lac boulogne, 4 avenue du spot 75015 Paris ... ) '
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class
        ]);
    }
}