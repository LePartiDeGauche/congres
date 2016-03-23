<?php

namespace AppBundle\Form\Election;

use AppBundle\Entity\AdherentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
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
