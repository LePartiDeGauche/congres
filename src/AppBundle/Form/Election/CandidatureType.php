<?php

namespace AppBundle\Form\Election;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Entity\Responsability;
use AppBundle\Entity\ResponsabilityRepository;

class CandidatureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $form = $event->getForm();
            $candidature = $event->getData();

            /* Check we're looking at the right data/form */
            if (false === $candidature instanceof \AppBundle\Entity\Election\Candidature) {
                throw new \InvalidArgumentException('Invalid Form data expected Candidature, got '.$candidature->getClassName());
            }

            $candidature->setResponsability($candidature->getCandidatureCall()->getResponsability());

            $form->add('responsability', 'entity', array(
                    'label' => 'Instance',
                    'class' => 'AppBundle:Responsability',
                    'disabled' => 'true',
                ))
                ->add('professionfoi', null, array(
                    'label' => 'Profession de foi',
                    'attr' => array(
                        'maxlength' => $candidature->getCandidatureCall()->getFaithProfessionLength(),
                        'data-help' => $candidature->getCandidatureCall()->getFaithProfessionLength() . ' signes maximum',
                    ),
                ))
                // ->add('isSortant', 'checkbox', array(
                //     'label' => 'Je suis candidat-e sortant-e d\'une instance nationale.',
                //     'required' => false,
                // ))
                // ->add('professionfoicplt', null, array('label' => 'Complément', 'required' => false))
                ->add('save', 'submit', array('label' => 'Enregistrer'));
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Election\Candidature',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_election_candidature';
    }
}
