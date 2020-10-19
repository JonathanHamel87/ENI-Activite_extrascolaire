<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Model\SortieFormulaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ;
        if ($options['mode'] == 'view'){
            $builder
                ->add('nom', TextType::class, [
                    'label' => 'Nom de la sortie :',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
                ->add('dateSortie', DateType::class, [
                    'label' => "Date limite d'inscription",
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yy hh:mm',
                    'html5' => false,
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                        'placeholder' => 'dd/MM/yy hh:mm'
                    ),
                    'disabled' => true,
                ])
                ->add('dateLimite', DateType::class, [
                    'label' => "Date limite d'inscription",
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yy hh:mm',
                    'html5' => false,
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                        'placeholder' => 'dd/MM/yy hh:mm'
                    ),
                    'disabled' => true,
                ])
                ->add('nombrePlace', IntegerType::class, [
                    'label' => 'Nombres de places : ',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
                ->add('duree', IntegerType::class, [
                    'label' => 'Durée : ',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description et infos : ',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
                ->add('campus', TextType::class, [
                    'label' => 'Campus :',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
                ->add('ville', TextType::class, [
                    'label' => 'Ville :',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
                ->add('lieu', TextType::class, [
                    'label' => 'Lieu :',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
                ->add('rue', TextType::class, [
                    'label' => 'Rue :',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
                ->add('codePostal', TextType::class, [
                    'label' => 'Code postal :',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
                ->add('latitude', TextType::class, [
                    'label' => 'Latitude :',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
                ->add('longitude', TextType::class, [
                    'label' => 'Longitude :',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])
            ;
        }
        if ($options['mode'] == 'add'){
            $builder
                ->add('nom', TextType::class, [
                    'label' => 'Nom de la sortie :',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                ])
                ->add('dateSortie', DateType::class, [
                    'label' => "Date limite d'inscription",
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yy hh:mm',
                    'html5' => false,
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                        'placeholder' => 'dd/MM/yy hh:mm'
                    ),
                ])
                ->add('dateLimite', DateType::class, [
                    'label' => "Date limite d'inscription",
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yy hh:mm',
                    'html5' => false,
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                        'placeholder' => 'dd/MM/yy hh:mm'
                    ),
                ])
                ->add('nombrePlace', IntegerType::class, [
                    'label' => 'Nombres de places : ',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                ])
                ->add('duree', IntegerType::class, [
                    'label' => 'Durée : ',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description et infos : ',
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                ])
                /*->add('campus', TextType::class, [
                    'label_attr' => array(
                        'class' => 'col-6'
                    ),
                    'attr' => array(
                        'class' => 'col-6',
                    ),
                    'disabled' => true,
                ])*/
                ->add('enregistrer', SubmitType::class, [
                    'attr' => array(
                        'class' => 'btn btn-secondary'
                    )
                ])
                ->add('publier', SubmitType::class, [
                    'attr' => array(
                        'class' => 'btn btn-secondary'
                    )
                ])
                ->add('annuler', SubmitType::class, [
                    'attr' => array(
                        'class' => 'btn btn-secondary'
                    )
                ])
            ;
        }

        //->add('supprimer', ButtonType::class)
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SortieFormulaire::class,
            'mode' => null,
        ]);
    }
}
