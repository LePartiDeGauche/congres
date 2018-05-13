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

        $form->add('elected', 'entity',  array(
            'label' => 'Adhérent-e-s élu-e-s',
            'expanded' => false,
            'multiple' => false,
            'required' => false,
            'placeholder' => 'Sélectionner un-e adhérent-e',
            'class' => 'AppBundle\Entity\Adherent',
            'query_builder' => function (AdherentRepository $repository) use ($organ) {
                return $repository->getSearchAdherentByOrganQueryBuilder($organ);
            },
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
