<?php

namespace AppBundle\Form\Election;

use AppBundle\Entity\AdherentRepository;
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
        $adherentOptions = array(
            'label' => "Adhérent élu",
            'expanded' => false,
            'multiple' => true,
            'class' => 'AppBundle\Entity\Adherent',
            'query_builder' => function(AdherentRepository $er) {
                $qb = $er->createQueryBuilder('a');
                $qb->orderBy('a.lastname', 'ASC');
                $qb->setMaxResults( '100' );
                return $qb;
            }

        );

        $builder->add('elected', 'entity', $adherentOptions)
                ->add('save', 'submit', array('label' => 'Enregistrer'))
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