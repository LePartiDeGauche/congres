<?php

namespace AppBundle\Form\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Form\Type\EntityTableType;

use AppBundle\Entity\Event\EventCostRepository;

class EventRegistrationPayType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $form = $event->getForm();
            $eventRegistration = $event->getData();

            /* Check we're looking at the right data/form */
            if (false === $eventRegistration instanceof \AppBundle\Entity\Event\EventAdherentRegistration) {
                throw new \InvalidArgumentException('Invalid Form data expected EventAdherentRegistration, got '.$eventRegistration->getClassName());
            }

            $curEvent = $eventRegistration->getEvent();
            $curAdherent = $eventRegistration->getAdherent();

            $form->add('author', 'text', array(
                'data_class' => 'AppBundle\Entity\Adherent',
                'label' => 'Utilisateur',
                'disabled' => 'true'
            ));

            $form->add('sleepingType', 'text', array(
                'data_class' => 'AppBundle\Entity\Event\EventSleepingType',
                'label' => 'Type d\'hébergement',
                'disabled' => 'true'
            ));

            $costChoices = array();
            foreach ($curEvent->getCosts() as $cost) {
                if ($cost->getSleepingType() == $eventRegistration->getSleepingType()) {
                    $costChoices[] = $cost;
                }
            }

            $form->add('cost', 'entity', array(
                'class' => 'AppBundle\Entity\Event\EventCost',
                'choices' => $costChoices,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Tarifs',
            ));

            $form->add('paymentMode', 'choice', array(
                'choices' => array(
                    'online' => 'Carte bleue ( Vous serez redirigé vers la page de paiement à la validation de l\'inscription )',
                    'onsite' => 'Par chèque ( libellé à l\'ordre du Parti de Gauche et envoyé au siège du PG, 20-22 rue Doudeauville, 75018 PARIS, en précisant sur l\'enveloppe "CN Janvier 2016" )', ),
                'expanded' => true,
                'label' => 'Mode de paiement',
            ));
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event\EventAdherentRegistration',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_event_registration_pay';
    }
}
