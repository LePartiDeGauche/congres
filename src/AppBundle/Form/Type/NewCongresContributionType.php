<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use AppBundle\Entity\Congres\Contribution;

class NewCongresContributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'choice', array(
                'choices' => array(
                    'generale' => 'Générale',
                    'thematique' => 'Thématique',
                    'statutaire' => 'Statutaire',
                ),
                'expanded' => true,
                'mapped' => false,
                'label' => 'Type de la contribution',
                'label_attr' => array(
                    'class' => 'radio-inline'
                )
        ));
        $builder->add('deposit_type', 'choice', array(
            'choices' => array(
                Contribution::DEPOSIT_TYPE_INDIVIDUAL => 'Dépôt individuel',
                Contribution::DEPOSIT_TYPE_SEN => 'Dépôt au nom du SEN',
                Contribution::DEPOSIT_TYPE_COMMISSION => 'Dépôt au nom d\'une commission thématique',
            ),
            'data' => Contribution::DEPOSIT_TYPE_INDIVIDUAL,
            'label' => 'Type de dépôt',
            'expanded' => true,
            'mapped' => false,
        ));
        $builder->add('deposit_type_value', 'text', array(
            'data' => '-',
            'label' => 'Précisez',
            'attr' => array(
                'data-help' => 'Le cas échéant, merci de préciser le nom de la commission thématique.'
            )
        ));
        $builder->add('title', null, array('label' => 'Titre'));
        $builder->add('content', null, array(
            'label' => 'Texte',
            'attr' => array(
                'class' => 'tinymce',
                'data-theme' => 'markdown',
            )
        ));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn-primary'),
        ));
    }

    public function getName()
    {
        return 'new_congres_contribution';
    }
}
