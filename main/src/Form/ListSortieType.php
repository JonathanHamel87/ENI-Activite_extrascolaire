<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
                'label_attr' => array(
                  'class' => 'col-6'
                ),
                'attr' => array(
                    'class' => 'col-6'
                )
            ])
            ->add('nomSortie', SearchType::class,[
                'label' => 'Le nom de la sotie contient :',
                'required' => false,
                'label_attr' => array(
                    'class' => 'col-6'
                ),
                'attr' => array(
                    'class' => 'col-6 rounded-pill',
                    'type' => 'search',
                    'placeholder' => 'search'
                )
            ])
            ->add('firstDate', DateType::class,[
                'label' => 'Entre ',
                'widget' => 'single_text',
                'required' => false,
                'label_attr' => array(
                    'class' => 'col-4'
                ),
                'attr' => array(
                    'class' => 'col-8'
                )
            ])
            ->add('secondeDate', DateType::class, [
                'label' => ' et ',
                'widget' => 'single_text',
                'required' => false,
                'label_attr' => array(
                    'class' => 'col-4'
                ),
                'attr' => array(
                    'class' => 'col-8'
                )
            ])
            ->add('bOrganisateur', CheckboxType::class, [
                'label' => "Sorties dont je suis l'organisateur/trice",
                'data' => true,
                'required' => false
            ])
            ->add('bInscrit', CheckboxType::class, [
                'label' => "Sorties auxquelles je suis inscrit/e",
                'data' => true,
                'required' => false,
            ])
            ->add('bNonInscrit', CheckboxType::class, [
                'label' => "Sorties auxquelles je ne suis pas inscrit/e",
                'data' => true,
                'required' => false,
            ])
            ->add('bFini', CheckboxType::class, [
                'label' => "Sorties passées",
                'data' => false,
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => array(
                    'class' => 'btn btn-secondary'
                )
            ])
            ->add('creerSortie', ButtonType::class, [
                'label' => 'Créer une sortie',
                'attr' => array(
                    'class' => 'btn btn-secondary',
                    'id' => 'create-sortie',
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Model\ListSortie'
        ));
    }
}
