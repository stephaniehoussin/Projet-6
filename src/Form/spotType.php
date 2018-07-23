<?php
namespace App\Form;

use App\Entity\Category;
use App\Entity\Spot;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class spotType
 * @package App\Form
 * @Vich\Uploadable
 */
class spotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('latitude', NumberType::class,array(
                'label' => 'Latitude'
            ))
            ->add('longitude', NumberType::class,array(
                'label' => 'Longitude'
            ))
            ->add('pictureFile', VichImageType::class,array(
                'label' => 'Image'
            ))
            ->add('title', TextType::class,array(
                'label' => 'Titre'
            ))
            ->add('description', TextareaType::class,array(
                'label' => 'Description'
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class
        ]);
    }
}