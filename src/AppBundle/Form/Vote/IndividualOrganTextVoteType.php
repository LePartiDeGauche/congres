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
            ->add('author')
            ->add('textGroup')
            ->add('organ')
            ->add('voteAbstention')
            ->add('voteNotTakingPart')
            ->add('textVoteAgregations', 'collections', array('type' => new IndividualOrganTextVoteAgregationType(), 'options' => array('vote_modality' => $options['vote_modality'])))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Vote\IndividualOrganTextVote'
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
