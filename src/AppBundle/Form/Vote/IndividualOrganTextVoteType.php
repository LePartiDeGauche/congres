<?php

namespace AppBundle\Form\Vote;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IndividualOrganTextVoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('voteAbstention', null, array( 'label' => 'Abstention' ))
            ->add('voteNotTakingPart', null, array( 'label' => 'Ne prend pas part au vote' ))
            ->add('textVoteAgregations', 'collection', array(
                'type' => new IndividualOrganTextVoteAgregationType(), 
                'options' => array('vote_modality' => $options['vote_modality']), 'label' => 'Textes'))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Vote\IndividualOrganTextVote',
            'vote_modality' => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_vote_individualorgantextvote';
    }
}
