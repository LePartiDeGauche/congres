<?php

namespace AppBundle\Form\Vote;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IndividualOrganTextVoteAgregationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('voteFor')
            ->add('voteAgainst')
            ->add('voteAbstention')
            ->add('individualOrganTextVote')
            ->add('text')
            ->add('textGroup')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Vote\IndividualOrganTextVoteAgregation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_vote_individualorgantextvoteagregation';
    }
}
