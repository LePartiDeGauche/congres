<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NewCongresContributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'choice', array(
                'choices' => array('generale' => 'Générale', 'thematique' => 'Thématique'),
                'choices_as_values' => false,
                'expanded' => true,
                'mapped' => false,
        ));
        $builder->add('title', null, array('label' => 'Titre'));
        $builder->add('content', null, array('label' => 'Texte'));
    }

    public function getName()
    {
        return 'new_congres_contribution';
    }
}
