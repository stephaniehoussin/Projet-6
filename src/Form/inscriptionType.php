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
            ->add('username', TextType::class,array(
                'label' => 'Pseudo'
            ))
            ->add('email', RepeatedType::class,array(
                'type' => EmailType::class,
                'required' => true,
                'first_options' => array('label' => 'Email'),
                'second_options' => array('label' => 'Email confirmation')
            ))
            ->add('password', RepeatedType::class,array(
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Mot de passe confirmation')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}