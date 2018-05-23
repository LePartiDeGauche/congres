<?php

namespace AppBundle\Form\Election;

use AppBundle\Entity\Election\ElectionResult;
use AppBundle\Entity\AdherentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ElectionResultType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, array($this, 'onPostSetData'));
    }

    public function onPostSetData(FormEvent $event) {
        if (null == $event->getData()) {
            return;
        }
        $form = $event->getForm();

        $electionResult = $event->getData();
        $election = $electionResult->getElection();
        $organ = $election->getOrgan();

        $form->add('elected', 'autocomplete', array(
            'label' => 'Adhérent-e-s élu-e-s',
            'class' => 'AppBundle:Adherent',
            'required' => false,
            'attr' => array(
                'data-help' => 'Merci de renseigner le nom de l\'adhérent-e élu-e.
                                Vous devez lancer une recherche suivant son nom, son prénom ou son email, puis le sélectionner dans la liste.',
                'class' => 'adherent-autocomplete'
            )
        ));

        $form->add('numberOfVote', null, array(
            'label' => 'Nombre de voix',
            'required' => false,
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ElectionResult::class,
            'validation_groups' => array('report_election'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'appbundle_election_election_result';
    }
}
