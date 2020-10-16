<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
            ->add('dateHeureDebut', DateType::class, [
                'label' => 'Date et heure de la sortie',
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
            ->add('dateLimiteInscription', DateType::class, [
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
            ->add('nbInscriptionMax', IntegerType::class, [
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
            ->add('infosSortie', TextareaType::class, [
                'label' => 'Description et infos : ',
                'label_attr' => array(
                    'class' => 'col-6'
                ),
                'attr' => array(
                    'class' => 'col-6',
                ),
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
                'label_attr' => array(
                    'class' => 'col-6'
                ),
                'attr' => array(
                    'class' => 'col-6',
                ),
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'label_attr' => array(
                    'class' => 'col-6'
                ),
                'attr' => array(
                    'class' => 'col-6',
                ),
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => array(
                    'class' => 'btn btn-secondary'
                )
            ])
            ->add('publier', ButtonType::class, [
                'label' => 'Publier la sortie',
                'attr' => array(
                    'class' => 'btn btn-secondary'
                )
            ])
            ->add('supprimer', ButtonType::class, [
                'label' => 'Supprimer la sortie',
                'attr' => array(
                    'class' => 'btn btn-secondary'
                )
            ])
            ->add('annuler', ButtonType::class, [
                'label' => 'Annuler',
                'attr' => array(
                    'class' => 'btn btn-secondary'
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
