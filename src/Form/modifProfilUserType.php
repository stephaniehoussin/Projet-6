<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class modifProfilUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,array(
                'label' => 'Pseudo',
                'required' => false
            ))
            ->add('email', EmailType::class,array(
                'label' => 'Email',
                'required' => false
            ));
    }
}