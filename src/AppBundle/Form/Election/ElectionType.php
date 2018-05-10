<?php

namespace AppBundle\Form\Election;

use AppBundle\Entity\AdherentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ElectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $election = $event->getData();
            $organ = $election->getOrgan();
            $form = $event->getForm();

            $form->add('responsable', 'text', array(
                'data_class' => 'AppBundle\Entity\Adherent',
                'label' => 'Déposant-e',
                'disabled' => 'true'
            ));

            $form->add('organ', 'text', array(
                'data_class' => 'AppBundle\Entity\Organ\Organ',
                'label' => 'Organe',
                'disabled' => 'true'
            ));

            $form->add('numberOfElected', 'text', array(
                'label' => 'Nombre de délégué.e.s à élire',
                'disabled' => 'true'
            ));

            $form->add('numberOfVoters', null, array(
                'label' => 'Nombre de votants',
            ));

            $form->add('blankVotes', null, array(
                'label' => 'Nombre de votes blancs ou nuls',
            ));

            $form->add('validVotes', null, array(
                'label' => 'Nombre de votes exprimés',
            ));

            $form->add('elected', 'entity',  array(
                'label' => 'Adhérents élus',
                'expanded' => false,
                'multiple' => true,
                'class' => 'AppBundle\Entity\Adherent',
                'query_builder' => function (AdherentRepository $repository) use ($organ) {
                    return $repository->getSearchAdherentByOrganQueryBuilder($organ);
                },
            ));
        });
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Election\Election',
            'validation_groups' => array('report_election'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'appbundle_election_election';
    }
}
