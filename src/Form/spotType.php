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
            ->add('latitude', HiddenType::class,array(
                'label' => 'latitude'
            ))
            ->add('longitude', HiddenType::class,array(
                'label' => 'longitude'
            ))
            ->add('pictureFile', VichImageType::class,array(
                'label' => 'image'
            ))
            ->add('title', TextType::class,array(
                'label' => 'title'
            ))
            ->add('description', TextareaType::class,array(
                'label' => 'description'
            ))
            ->add('category', EntityType::class,array(
                'label' => 'choisir la catégorie',
                    'class' => Category::class,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class
        ]);
    }
}