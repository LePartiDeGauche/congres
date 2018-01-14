<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
