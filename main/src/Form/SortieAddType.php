<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie : '
            ])
            ->add('dateHeureDebut', DateType::class, [
                'label' => 'Date et heure de la sortie',
                'widget' => 'single_text',
                'format' => 'dd/MM/yy hh:mm',
                'html5' => false,
                'attr' => array(
                    'placeholder' => 'dd/MM/yy hh:mm'
                )
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'label' => "Date limite d'inscription",
                'widget' => 'single_text',
                'format' => 'dd/MM/yy hh:mm',
                'html5' => false,
                'attr' => array(
                    'placeholder' => 'dd/MM/yy hh:mm'
                )
            ])
            ->add('nbInscriptionMax', IntegerType::class, [
                'label' => 'Nombre de places : '
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée : ',
            ])
            ->add('infosSortie', TextareaType::class, [
                'label' => 'Description et infos : '
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
                'disabled' => true,
            ])
            /*->add('ville', EntityType::class, [
                'label' => 'Ville : ',
                'class' => Ville::class,
                'choice_label' => 'nom',
            ])*/
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom'
            ])
            /*->add('rue', TextType::class, [
                'label' => 'Rue : ',
                'disabled' => true,
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal : ',
                'disabled' => true,
            ])*/
            /*->add('latitude', TextType::class, [
                'label' => 'Latitude : '
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Longitude : '
            ])*/
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => array(
                    'class' => 'btn btn-secondary'
                )
            ])
            ->add('publier', SubmitType::class, [
                'label' => 'Publier la sortie',
                'attr' => array(
                    'class' => 'btn btn-secondary'
                )
            ])
            ->add('annuler', SubmitType::class, [
                'label' => 'annuler',
                'attr' => array(
                    'class' => 'btn btn-secondary'
                )
            ])
            /*->add('organisateur', EntityType::class, [
                'class' => Participant::class,
            ])*/
            /*->add('participants', CollectionType::class, [

            ])
            ->add('lieux')
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
