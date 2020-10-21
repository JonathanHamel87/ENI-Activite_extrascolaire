<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Pseudo :',
                'label_attr' => array(
                  'class' => 'col-5'
                ),
                'attr' => array(
                    'class' => 'col-7'
                ),
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom :',
                'label_attr' => array(
                    'class' => 'col-5'
                ),
                'attr' => array(
                    'class' => 'col-7'
                )
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom :',
                'label_attr' => array(
                    'class' => 'col-5'
                ),
                'attr' => array(
                    'class' => 'col-7'
                )
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone :',
                'label_attr' => array(
                    'class' => 'col-5'
                ),
                'attr' => array(
                    'class' => 'col-7'
                )
            ])
            ->add('mail', TextType::class, [
                'label' => 'Email :',
                'label_attr' => array(
                    'class' => 'col-5'
                ),
                'attr' => array(
                    'class' => 'col-7'
                )
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mot de passe doivent être identique',
                'required' => false,
                'mapped' => false,
                'first_options'  => ['label' => 'Mot de passe :'],
                'second_options' => ['label' => 'Confirmation :'],
                'options' => array(
                    'attr' => array(
                        'class' => 'password-field col-7'
                    ),
                    'label_attr' => array(
                        'class' => 'col-5'
                    )
                )
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
                'label_attr' => array(
                    'class' => 'col-5'
                ),
                'attr' => array(
                    'class' => 'col-7'
                )
            ])
            ->add('photo', FileType::class,[
                'label' => 'Ma photo',
                'mapped' => false,
                'required' => false,
                'label_attr' => array(
                    'class' => 'col-5'
                ),
                'attr' => array(
                    'class' => 'col-7'
                )
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => array(
                    'class' => 'btn btn-success'
                )
            ])
            ->add('annuler', ButtonType::class,[
                'label' => 'Annuler',
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ])
        ;
        if ($options['mode'] == 'show'){
            $builder
                ->remove('username')
                ->remove('password')
                ->remove('enregistrer')
                ->remove('annuler')
                ->remove('photo')
                ->add('retour', SubmitType::class, [
                    'label' => 'Retour',
                    'attr' => array(
                        'class' => 'btn btn-secondary'
                    )
                ])

                ->add('nom', TextType::class, [
                    'label' => 'Nom :',
                    'label_attr' => array(
                        'class' => 'col-5'
                    ),
                    'attr' => array(
                        'class' => 'col-7'
                    ),
                    'disabled' => true
                ])
                ->add('prenom', TextType::class, [
                    'label' => 'Prénom :',
                    'label_attr' => array(
                        'class' => 'col-5'
                    ),
                    'attr' => array(
                        'class' => 'col-7'
                    ),
                    'disabled' => true
                ])
                ->add('telephone', TextType::class, [
                    'label' => 'Téléphone :',
                    'label_attr' => array(
                        'class' => 'col-5'
                    ),
                    'attr' => array(
                        'class' => 'col-7'
                    ),
                    'disabled' => true
                ])
                ->add('mail', TextType::class, [
                    'label' => 'Email :',
                    'label_attr' => array(
                        'class' => 'col-5'
                    ),
                    'attr' => array(
                        'class' => 'col-7'
                    ),
                    'disabled' => true
                ])
                ->add('campus', EntityType::class, [
                    'class' => Campus::class,
                    'choice_label' => 'nom',
                    'label_attr' => array(
                        'class' => 'col-5'
                    ),
                    'attr' => array(
                        'class' => 'col-7'
                    ),
                    'disabled' => true
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
            'mode' => null,
        ]);
    }
}
