<?php

namespace AppBundle\Form\Election;

use AppBundle\Entity\Election\Election;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                'label' => 'Nombre de votes nuls',
            ));

            $form->add('validVotes', null, array(
                'label' => 'Nombre de votes exprimés (y compris les blancs)',
            ));

            $form->add('minutesDocumentFile', 'file', array(
                'label' => 'Déposer le procès verbal',
                'required' => false,
                'attr' => array(
                    'data-help' => 'Fichier de type image, document ou tableur',
                    'class' => 'contact-info'
                )
            ));

            $form->add('tallySheetFile', 'file', array(
                'label' => 'Déposer la liste d\'émargement',
                'required' => false,
                'attr' => array(
                    'data-help' => 'Fichier de type image, document ou tableur',
                    'class' => 'contact-info'
                )
            ));

            $form->add('maleElectionResults', 'collection',  array(
                'label' => 'Adhérents élus',
                'type' => new ElectionResultType(),
                'options' => array('label' => false),
                'by_reference' => false,
                'prototype' => true,
            ));

            $form->add('femaleElectionResults', 'collection',  array(
                'label' => 'Adhérentes élues',
                'type' => new ElectionResultType(),
                'options' => array('label' => false),
                'by_reference' => false,
                'prototype' => true,
            ));

            $form->add('submit', 'submit', array(
                'label' => 'Valider les résultats',
            ));

        });
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Election::class,
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
