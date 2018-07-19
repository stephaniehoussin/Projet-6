<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class inscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class,array(
                'label' => 'pseudo'
            ))
            ->add('email', RepeatedType::class,array(
                'type' => EmailType::class,
                'required' => true,
                'first_options' => array('label' => 'email'),
                'second_options' => array('label' => 'email confirmation')
            ))
            ->add('password', RepeatedType::class,array(
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => array('label' => 'password'),
                'second_options' => array('label' => 'password confirmation')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}