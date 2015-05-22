<?php

namespace AppBundle\Form\Election;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ElectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('election', 'entity')
            ->add('result', null, array('label' => 'Resultat'))

        ;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Election\Election',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_election_election';
    }
}