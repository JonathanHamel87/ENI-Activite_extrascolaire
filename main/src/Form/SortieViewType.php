<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieViewType extends AbstractType
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
                )
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
                )
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
                )
            ])
            ->add('nbInscriptionMax', IntegerType::class, [
                'label' => 'Nombres de places : ',
                'label_attr' => array(
                    'class' => 'col-6'
                ),
                'attr' => array(
                    'class' => 'col-6',
                )
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée : ',
                'label_attr' => array(
                    'class' => 'col-6'
                ),
                'attr' => array(
                    'class' => 'col-6',
                )
            ])
            ->add('infosSortie', TextareaType::class, [
                'label' => 'Description et infos : ',
                'label_attr' => array(
                    'class' => 'col-6'
                ),
                'attr' => array(
                    'class' => 'col-6',
                )
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
                'label_attr' => array(
                    'class' => 'col-6'
                ),
                'attr' => array(
                    'class' => 'col-6',
                )
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'label_attr' => array(
                    'class' => 'col-6'
                ),
                'attr' => array(
                    'class' => 'col-6',
                )
            ])
            /*->add('rue', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'rue'
            ])
            ->add('codePostal', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'codePostal'
            ])
            ->add('latitude', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'latitude'
            ])
            ->add('longitude', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'longitude'
            ])*/
            /*->add('participants', CollectionType::class, [
                'class' => Participant::class,
                'choices' => $sortie->getParticipants()
            ])*/
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
