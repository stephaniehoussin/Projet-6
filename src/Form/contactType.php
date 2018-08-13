<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class contactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,array(
                'label' => 'Votre adresse Email',
                'attr' => array(
                    'placeholder' => 'email@gmail.com'
                ),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Merci de saisir votre adresse email'
                    )),
                    new Assert\Email(array(
                        'checkMX' => true,
                        'message' => 'Merci de saisir une adresse email valide'
                    ))
                )

            ))
          ->add('sujet', TextType::class,array(
              'label' => 'Sujet',
              'constraints' => array(
                  new Assert\NotBlank(array(
                      'message' => 'Merci de saisir un sujet'
                  ))
              )
          ))
            ->add('message', TextareaType::class,array(
                'label' => 'Message',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Merci de saisir votre message'
                    ))
                )
            ))
            ->add('conform', CheckboxType::class,array(
                'label' => 'En cliquant sur le bouton Envoyer et en soumettant le formulaire,
                j\'accepte que mes données personnelles soient utilisées pour me recontacter
                dans le cadre de ma demande indiquée dans ce formulaire.
                Aucun autre traitement ne sera effectué avec mes informations.',
                'required' => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}