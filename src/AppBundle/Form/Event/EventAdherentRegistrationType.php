<?php

namespace AppBundle\Form\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventAdherentRegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('needHosting', null, array('label' => 'J\'ai besoin d\'un hébergement militant', 'required' => false))
            ->add('comment')
            ->add('paymentMode', 'choice',
                array(
                    'choices' => array(
                        'online' => 'Carte bleue ( Vous serez redirigé vers la page de paiement à la validation de l\'inscription )',
                        'onsite' => 'Par chèque ( libellé à l\'ordre du Parti de Gauche et envoyé au siège du PG, 20-22 rue Doudeauville, 75018 PARIS, en précisant sur l\'enveloppe "CN avril 2015" )', ),
                    'expanded' => true,
                    'label' => 'Mode de paiement',
                ))
                ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $form = $event->getForm();
            $data = $event->getData();

            /* Check we're looking at the right data/form */
            if ($data instanceof \AppBundle\Entity\Event\EventAdherentRegistration) {
                $curEvent = $data->getEvent();
                $curAdherent = $data->getAdherent();

                $mealsOptions = array(
                    'class' => 'AppBundle\Entity\Event\EventMeal',
                    'query_builder' => function (\AppBundle\Entity\Event\EventMealRepository $er) use ($curEvent) {
                        return $er->findByEventQueryBuider($curEvent);
                    },
                    'expanded' => true,
                    'multiple' => true,
                    'label' => 'Repas',
                );

                $form->add('meals', 'entity', $mealsOptions);

                $costOptions = array(
                    'class' => 'AppBundle\Entity\Event\EventCost',
                    'query_builder' => function (\AppBundle\Entity\Event\EventCostRepository $er) use ($curEvent) {
                        return $er->findByEventQueryBuider($curEvent);
                    },
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'Tranche de revenu :',
                );

                $form->add('cost', 'entity', $costOptions);

                if ($curAdherent != null) {
                    $roleOptions = array(
                        'class' => 'AppBundle\Entity\Event\EventRole',
                        'query_builder' => function (\AppBundle\Entity\Event\EventRoleRepository $er) use ($curEvent, $curAdherent) {
                            return $er->findByEventAndAdherentQueryBuider($curEvent, $curAdherent);
                        },
                        'expanded' => false,
                        'multiple' => false,

                    );
                    $form->add('role', 'entity', $roleOptions);
                }
            } else {
                throw new \InvalidArgumentException('Invalid Form data expected EventAdherentRegistration, got '.$data->getClassName());
            }
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
        return 'appbundle_event_eventadherentregistration';
    }
}
